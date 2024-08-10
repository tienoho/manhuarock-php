<?php

namespace Command;

use CrawlHelpers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Promise\EachPromise;
use Models\Manga;
use Models\Model;
use Models\Taxonomy;
use Psr\Http\Message\ResponseInterface;
use Services\Local;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\PdoStore;

class AutoManga extends CrawlHelpers
{
    use LockableTrait;

    protected static $defaultName = 'auto:manga';

    public $source;
    public $config;
    public $URLS = [];

    public $INFO = [];

    public $store;
    public $factory;
    private $client;

    protected function configure(): void
    {
        $this->addArgument('source', InputArgument::OPTIONAL, 'Source');
        $this->addOption('update', null, InputOption::VALUE_OPTIONAL, '', 0);
        $this->addOption('page', null, InputOption::VALUE_OPTIONAL, '', 1);
        $this->addOption('link', null, InputOption::VALUE_OPTIONAL, '', 0);
    }

    public function checkMaxProcess(): bool
    {
        $lock = true;
        $max_process = $this->config->max_process_running;
        $current_process = 1;

        while ($current_process <= $max_process) {
            if ($this->lock(md5(__DIR__ . self::$defaultName . $this->source . $current_process))) {
                $lock = false;
                break;
            }
            $current_process++;
        }

        return $lock;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $page = 1;

        if ($this->checkMaxProcess()) {
            exit('The command is already running in another process.');
        }

        while (true) {
            if ($input->getOption('update')) {
                if ($page > $this->config->max_page_update) {
                    break;
                }
            } else {
                if (isset($this->config->current_page)) {
                    $page = $page !== $this->config->current_page ? $this->config->current_page : $page;
                }
            }

            try {
                $this->URLS = [];

                if ($input->getOption('link')) {
                    $page = 1;
                    $link = $input->getOption('link');
                    if (filter_var($link, FILTER_VALIDATE_URL) === false) {
                        $helper = $this->getHelper('question');

                        while (true) {

                            $url = $helper->ask(
                                $input,
                                $output,
                                new Question("Nhập URL [0: thoát]: ", 0)
                            );

                            if (!$url) {
                                break;
                            }

                            $this->URLS[] = $url;
                        }
                    } else {
                        if ($page == 1) {
                            $this->URLS[] = $link;
                        }
                    }
                } else {
                    $output->writeln("Crawled: $page");
                    $this->URLS = $this->crawler->list($page);
                }
            } catch (\Exception $e) {
                $this->URLS = [];
                $output->writeln("<comment>Can't find any manga url, please check campaign or source!</comment>");
                $output->writeln($e);
                break;
            }

            if (!$this->URLS) {
                $output->writeln("<info>Done!</info>");
                break;
            }

            foreach ($this->URLS as $k => $url) {
                unset($this->URLS[$k]);

                $lock = $this->factory->createLock(md5($url), 300);
                if (!$lock->acquire()) {
                    $output->writeln("<comment>[Running]</comment> $url");
                    continue;
                }

                try {
                    $output->writeln("<info>[Begin]</info> $url");

                    $this->INFO = $this->crawler->info($url);

                    $isNewManga = false;

                    $manga = Manga::getDB()->where('name', $this->INFO['name'])
                        ->getOne('mangas', 'id, cover');

                    $MID = $manga['id'];

                    $slug = $this->INFO['slug'] ?? slugGenerator($this->INFO['name']);



                    if (!$MID) {
                        if ($this->config->only_update && $input->getOption('update')) {
                            continue;
                        }

                        // Manga cover
                        if ($this->config->save_poster) {
                            $path = "covers/$slug.jpg";
                            $imgData = $this->crawler->bypass($this->INFO['cover']);

                            if (!empty($imgData)) {
                                $this->INFO['cover'] = (new ("\\Services\\" . $this->config->save_poster_to_remote))->upload($imgData, $path);
                                $update_data['cover'] = $this->INFO['cover'];
                            }
                        }

                        $isNewManga = true;

                        // Save Manga Data
                        $MID = Manga::AddManga(array_filter([
                            'name' => $this->INFO['name'],
                            'slug' => $slug,
                            'other_name' => $this->INFO['other_name'] ?? null,
                            'description' => $this->INFO['description'] ?? null,
                            'released' => $this->INFO['released'] ?? null,
                            'country' => $this->INFO['country'] ?? null,
                            'type' => $this->INFO['type'] ?? null,
                            'views' => $this->INFO['views'] ?? 0,
                            'adult' => $this->INFO['adult'] ?? 0,
                            'status' => $this->INFO['status'] ?? 'on-going',
                            'cover' => $this->INFO['cover'],
                            'last_update' => Manga::getDB()->now(),

                        ]));

                        $output->writeln("<comment>[New Manga]</comment> " . $this->INFO['name']);
                    }

                    if (!is_int($MID)) {
                        continue;
                    }

                    foreach ($this->INFO['taxonomy'] as $taxonomy => $taxonomy_data) {
                        if (!empty($taxonomy_data) && is_array($taxonomy_data)) {
                            $taxonomy_data = array_filter($taxonomy_data);

                            if (!empty($taxonomy_data) && is_array($taxonomy_data)) {
                                $taxonomy_data = array_filter($taxonomy_data);
                                Taxonomy::SetTaxonomy($taxonomy, $taxonomy_data, $MID);
                            }
                        }
                    }

                    $checkList = [];
                    if (!$isNewManga) {
                        $savedChapters = Model::getDB()->where('manga_id', $MID)->get('chapters');

                        foreach ($savedChapters as $chap) {
                            $checkList[] = $chap['slug'];
                        }

                        $checkList = array_flip($checkList);
                    }

                    $c_index = count($checkList) + 1;
                    foreach ($this->INFO['list_chapter'] as $chap) {
                        $chap['slug'] = slugGenerator($chap['name']);
                        if (
                            key_exists($chap['slug'], $checkList)
                            ||
                            Model::getDB()->where('name', $chap['name'])
                            ->where('manga_id', $MID)
                            ->getValue('chapters', 'id')
                        ) {
                            $output->writeln('<comment>[Exist]</comment> ' . $this->INFO['name'] . ' - ' . $chap['name']);
                            continue;
                        }

                        Model::getDB()->startTransaction();
                        try {
                            $output->writeln('<info>[New]</info> <comment>' . $this->INFO['name'] . ' - ' . $chap['name'] . '</comment>');

                            $CID = Model::getDB()->insert('chapters', [
                                'name' => $chap['name'],
                                'name_extend' => $chap['name_extend'] ?? null,
                                'slug' => $chap['slug'],
                                'chapter_index' => $c_index++,
                                'manga_id' => $MID,
                                'views' => 0,
                                'hidden' => 1,
                            ]);

                            if (!is_int($CID)) {
                                Model::getDB()->rollback();
                                continue;
                            }

                            $CTID = Model::getDB()->insert('chapter_data', [
                                'type' => 'leech',
                                'chapter_id' => $CID,
                                'source' => $chap['url'],
                                'content' => $chap['url'],
                                'storage' => $this->source,
                                'storage_name' => 'Server 1',
                                'used' => 1,
                            ]);

                            $new_op = $this->crawler;
                            $chapContent = $new_op->content($chap['url']);
                            if (empty($chapContent)) {
                                Model::getDB()->rollback();
                                continue;
                            }

                            $CTimages = [];
                            $ChapCT = $chapContent['content'];

                            if ($chapContent['type'] == 'image') {
                                $image_count = count($chapContent['content']);
                                $progressBar = new ProgressBar($output->section());
                                $progressBar->start($image_count);
                                $i = 1;
                                $ServicesUpload = ("\\Services\\" . $this->config->server_image);

                                if (!empty($this->config->server_image) && class_exists($ServicesUpload)) {
                                    $ServicesUpload = new $ServicesUpload;
                                    $promises = [];
                                    foreach ($chapContent['content'] as $url) {
                                        $promises[] = $this->client->getAsync($url, $new_op->options)->then(
                                            function (ResponseInterface $response) use ($url, $output) {
                                                if ($response->getStatusCode() !== 200) {
                                                    $msg = "Empty data in $url";

                                                    $output->writeln($msg);
                                                    Model::getDB()->rollback();
                                                    exit();
                                                }

                                                return ($response->getBody()->getContents());
                                            },
                                            function (ConnectException $e) use ($url, $output) {
                                                $msg = "Can't Get Data From $url";

                                                $output->writeln($msg);
                                                Model::getDB()->rollback();

                                                echo $e->getMessage();
                                                exit();
                                            }
                                        );
                                    }

                                    $promise = new EachPromise($promises, [
                                        'concurrency' => 10,
                                        'fulfilled' => function ($image_data, $index) use ($MID, $CID, $ServicesUpload, &$CTimages, $output) {
                                            $image_path = "mangas/$MID/$CID/" . uniqid() . ".jpg";
                                            $image_url = $ServicesUpload->upload($image_data, $image_path);

                                            try {
                                                $CTimages[$index] = $image_url;
                                            } catch (ConnectException $e) {
                                                $msg = "Can't Save Image To " . $this->config->server_image;
                                                $output->writeln($e);

                                                Model::getDB()->rollback();
                                                exit($msg);
                                            }
                                        }
                                    ]);

                                    $promise->promise()->wait();

                                    ksort($CTimages);

                                    $progressBar->finish();
                                } else {
                                    $CTimages = $chapContent['content'];
                                }

                                $progressBar->finish();

                                $ChapCT = json_encode($CTimages);
                            }

                            Model::getDB()->where('id', $CTID)->update('chapter_data', [
                                'type' => $chapContent['type'],
                                'content' => $ChapCT,
                                'used' => 0,
                                'storage_name' => $this->config->server_image,
                            ]);

                            Model::getDB()->where('id', $CID)->update('chapters', [
                                'hidden' => 0,
                            ]);

                            Manga::UpdateLastChapter($MID);
                            Manga::getDB()->where('id', $MID)
                                ->update('mangas', [
                                    'last_update' => Manga::getDB()->now(),
                                ]);

                            Model::getDB()->commit();
                        } catch (\Exception $e) {
                            Model::getDB()->rollback();
                        }
                    }

                    $update_data['last_update'] = Manga::getDB()->now();


                    // Update Manga Data
                    Manga::getDB()->where('id', $MID)
                        ->update('mangas', $update_data);

                    $update_data = [];

                    // perform a job during less than 30 seconds
                } catch (\Exception $e) {
                    Model::getDB()->insert('auto_logs', [
                        'title' => 'Unable to find data',
                        'url' => $url,
                        'description' => $e->getMessage(),
                    ]);
                } finally {
                    $lock->release();
                }
                // END single manga
            }

            $page++;
            // Update config
            $this->config->current_page = $page;

            file_put_contents(
                sprintf("%s/config/auto-manga-%s.json", ROOT_PATH, strtolower($this->source)),
                json_encode($this->config)
            );

            if (isset($link) && !empty($link) && empty($this->URLS)) {
                break;
            }
        }

        $this->release();
        return Command::SUCCESS;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $db_config = getConf('database');

        $host = $db_config['DB_HOST'];
        $dbName = $db_config['DB_NAME'];

        $databaseConnectionOrDSN = "mysql:host=$host;dbname=$dbName";
        $this->store = new PdoStore($databaseConnectionOrDSN, ['db_username' => $db_config['DB_USER'], 'db_password' => $db_config['DB_PASSWORD']]);
        $this->factory = new LockFactory($this->store);

        $helper = $this->getHelper('question');

        $this->source = $input->getArgument('source');

        if (!$this->source) {
            $output->writeln('<comment>Bỏ trống mặc định = 0</comment>');

            $this->source = $helper->ask(
                $input,
                $output,
                new ChoiceQuestion("Chọn nguồn: ", $this->scraplist())
            );
        }

        $this->config = json_decode(file_get_contents(ROOT_PATH . '/config/auto-manga.json'));
        $config_path = ROOT_PATH . '/config/auto-manga-' . strtolower($this->source) . '.json';

        if (file_exists($config_path)) {
            $campaign_config = json_decode(file_get_contents($config_path));

            foreach ($campaign_config as $key => $config) {
                $this->config->{$key} = $config;
            }
        }

        // initialize
        $class = '\\Crawler\\' . $this->source;
        $this->crawler = new $class;

        $this->client = new Client([
            "request.options" => array(
                $this->crawler->options,
            ),
        ]);

        $this->site_url = getConf('site')['site_url'];

        parent::initialize($input, $output);
    }
}
