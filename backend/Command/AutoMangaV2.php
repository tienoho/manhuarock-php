<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

define('LOG_PATH', ROOT_PATH . '/logs');

class AutoMangaV2 extends Command
{
    protected static $defaultName = 'manga:tools';

    public $source;
    private $client;

    /*
    * var $redis \Predis\Client
    * var $client \GuzzleHttp\Client
    */

    private $redis;

    protected function configure(): void
    {
        $this->addArgument('source', InputArgument::OPTIONAL, 'Source');

        $this->addArgument('thead_id', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        if (empty($this->thead_id)) {
            // Lock process by source
            $lock_process_key = "lock_process:{$this->source}";

            $lock = $this->redis->get($lock_process_key);

            if ($lock) {
                $output->writeln('Process is running');
                return Command::SUCCESS;
            }

            try {
                $this->redis->set($lock_process_key, 1);
                $this->redis->expire($lock_process_key, 300);

                $this->parentThead($input, $output);
            } catch (\Exception$e) {
                $output->writeln($e);
            } finally {
                $this->redis->del($lock_process_key);
            }

        } else {
            $this->childThead($input, $output);
        }

        return Command::SUCCESS;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        chdir(ROOT_PATH . '/backend');

        ini_set('memory_limit', '-1');
        set_time_limit(0);

        // Config
        $this->config = include ROOT_PATH . '/config/tools-v2/config.php';

        // Redis cache
        $this->redis = $this->config['redis'];

        // Check redis connection
        try {
            $this->redis->connect();
        } catch (\Exception$e) {
            die('Redis connection error');
        }

        // Get thead id
        $this->thead_id = $input->getArgument('thead_id');

        $this->source = $input->getArgument('source');

        parent::initialize($input, $output);
    }

    public function parentThead($input, $output)
    {
        $output->writeln('Start manga scraper for ' . $this->source . ' source');

        // Get source
        if (!$this->source) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Please select source',
                $this->getSources(),
                0
            );

            $question->setErrorMessage('Source %s is invalid.');
            $this->source = $helper->ask($input, $output, $question);
        }

        // Get crawler class
        $source_class = "\\Crawler\\$this->source";
        $this->crawler = new $source_class();

        // Get thead count form config
        $thead_count = $this->config['max_thread'];

        // check OS - run command in background php bin/console manmga:tools source thead_id
        if ($this->isWindows()) {
            $cmd = "php bin/console manga:tools {$this->source} %d";
        } else {
            $cmd = "php bin/console manga:tools {$this->source} %d > /dev/null &";
        }

        // Generate thead count
        $this->redis->set("{$this->source}:thead:count", 0);

        // Start thead
        for ($i = 1; $i <= $thead_count; $i++) {
            $command = sprintf($cmd, $i);
            exec($command);
        }

        do {
            $count = $this->redis->get("{$this->source}:thead:count");

            // show log from redis
            $log = $this->redis->get("{$this->source}:log");
            if ($log) {
                $output->writeln($log);

                $this->redis->del("{$this->source}:log");
            }

            // sleep mili second
            if ($count < $thead_count){
                usleep(100000);
            }
        } while ($count < $thead_count);

        // Finish thead
        $this->redis->del("{$this->source}:thead:count");
        $output->writeln("Finish thead {$thead_count} for {$this->source}");
    }

    public function childThead($input, $output)
    {
        // Get source
        $this->writeLog("Start thead {$this->thead_id} of {$this->source}");

        $curren_thead_count = $this->redis->get("{$this->source}:thead:count");

        // Finish thead
        $this->redis->incr("{$this->source}:thead:count");
    }

    protected function getSources()
    {
        $sources = [];

        foreach (glob(__DIR__ . '/../Crawler/*.php') as $file) {

            $sources[] = basename($file, '.php');
        }

        return $sources;
    }

    protected function isWindows()
    {
        return strtolower(substr(PHP_OS, 0, 3)) === 'win';
    }

    protected function writeLog($message, $file_name = 'running.log')
    {
        // max log line
        $max_line = 1000;

        $filePath = realpath(LOG_PATH . '/' . $file_name);

        if (!file_exists($filePath)) {
            touch($filePath);
        }

        $lines = count(file($filePath));

        if ($lines > $max_line) {

            $content = file_get_contents($filePath);

            $content = explode(PHP_EOL, $content);

            $content = array_slice($content, $lines - $max_line);

            $content = implode(PHP_EOL, $content);

            file_put_contents($filePath, $content);
        }

        $message = trim($message) . PHP_EOL;

        $log_time = date('Y-m-d H:i:s');

        $log = "{$log_time} - {$message}";

        file_put_contents(LOG_PATH . '/' . $file_name, $log, FILE_APPEND);

        // write log to redis
        $this->redis->append("$this->source:log", $log);
    }

}
