<?php


namespace Controllers;

use Models\Model;
use Services\Blade;
use Symfony\Component\Process\PhpExecutableFinder;

class AutoTool
{
    public $tool_config;
    public $php_path = 'php';

    public function __construct()
    {
        chdir(ROOT_PATH . '/backend');

        $php = (new PhpExecutableFinder)->find();
        if (!empty($php)) {
            $this->php_path = $php;
        }

        $active_file = ROOT_PATH . '/config/active-tool.json';

        if (!file_exists(ROOT_PATH . '/config/active-tool.json')) {
            if (!Model::getDB()->tableExists(['crawl_queue'])) {
                Model::getDB()->rawQuery(
                    "CREATE TABLE `crawl_queue` (
                             `id` int(11) NOT NULL,
                             `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
                             `source` text COLLATE utf8mb4_unicode_ci NOT NULL,
                             `running` tinyint(1) NOT NULL DEFAULT '0'
                          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
                );
            }

            file_put_contents($active_file, json_encode([
                'day_active' => date('dd-mm-yy')
            ]));
        }

        $this->tool_config = json_decode(file_get_contents(ROOT_PATH . "/config/auto-manga.json"));
    }

    function index()
    {
        return (new Blade())->render('autosite.index', [
            'tool_config' => $this->tool_config
        ]);
    }

    function configuration()
    {
        return (new Blade())->render('autosite.configuration', [
            'tool_config' => $this->tool_config
        ]);
    }

    function campaign()
    {
        return (new Blade())->render('autosite.campaign', [
            'tool_config' => $this->tool_config
        ]);
    }

    function addCampaign()
    {
        $name = input()->value('name');
        $content = input()->value('content');

        if (empty($name) || empty($content)) {
            response()->httpCode(200)->json([
                'mgs' => 'Not Be Empty Any Field!',
                'status' => false
            ]);
        }

        $name = ucfirst($name);

        $file_crawler = ROOT_PATH . "/backend/Crawler/$name.php";
        if (file_exists($file_crawler)) {
            response()->httpCode(200)->json([
                'mgs' => 'Campaign already exists!',
                'status' => false
            ]);
        }

        $content = base64_decode(reverse_string($content));
        $class = trim(explode_by("class ", ' ', $content));

        if (strpos($content, 'namespace Crawler') === false || empty($class)) {
            response()->httpCode(200)->json([
                'mgs' => 'Invalid campaign!',
                'status' => false
            ]);
        }

        $content = str_replace("class $class", "class $name", $content);

        file_put_contents($file_crawler, $content);

        response()->httpCode(200)->json([
            'mgs' => 'Added campaign!',
            'status' => true
        ]);
    }

    function editCampaign()
    {
        $name = input()->value('name');
        $current_path = ROOT_PATH . input()->value('current_path');
        $content = input()->value('content');

        if (empty($name) || empty($content)) {
            response()->httpCode(200)->json([
                'mgs' => 'Not Be Empty Any Field!',
                'status' => false
            ]);
        }

        $name = ucfirst($name);
        $file_crawler = ROOT_PATH . "/backend/Crawler/$name.php";

        $content = base64_decode(reverse_string($content));

        $class = trim(explode_by("class ", ' ', $content));

        if (strpos($content, 'namespace Crawler') === false || empty($class)) {
            response()->httpCode(200)->json([
                'mgs' => 'Invalid campaign!',
                'status' => false
            ]);
        }

        $content = str_replace("class $class", "class $name", $content);

        unlink($current_path);
        file_put_contents($file_crawler, $content);

        response()->httpCode(200)->json([
            'mgs' => 'Edited campaign!',
            'status' => true
        ]);
    }

    function cronManage()
    {
        $listCRON = \Crontab::getJobs() ?? [];

        return (new Blade())->render('autosite.cron-manage', [
            'tool_config' => $this->tool_config,
            'listCRON' => ($listCRON),
        ]);
    }

    function addCron()
    {
        $time = input()->value('time');
        $task = input()->value('task');

        if (empty($task)) {
            response()->json([
                'status' => false,
                'msg' => 'Task not vaild!'
            ]);
        }

        if (empty($time) || strlen($time) > 13) {
            response()->json([
                'status' => false,
                'msg' => 'Invalid time!'
            ]);
        }

        $path = realpath(ROOT_PATH . '/backend');

        switch ($task) {
            case 'Auto Manga':
                $campaign = input()->value('campaign');

                if (empty($campaign) || !class_exists("\\Crawler\\$campaign")) {
                    response()->json([
                        'status' => false,
                        'msg' => 'Campaign not vaild!'
                    ]);
                }

                $cron_command = "$time cd $path && $this->php_path bin/console auto:manga $campaign --update=1";
                break;
            case 'Auto Sitemap':
                $cron_command = "$time cd $path && $this->php_path bin/console app:sitemap";
                break;
            case 'Clear Cache':
                $cron_command = "$time cd $path && $this->php_path bin/console cache:clear";
                break;
            default:
                response()->json([
                    'status' => false,
                    'msg' => 'Task not exist!'
                ]);
        }

        if (\Crontab::addJob($cron_command) !== false) {
            response()->json([
                'status' => true,
            ]);
        } else {
            response()->json([
                'status' => false,
                'msg' => $cron_command
            ]);
        }

    }

    function removeCron()
    {
        $id = input()->value('id');

        $cron = \Crontab::getJobs();

        if (!empty($id) || !empty($cron)) {
            \Crontab::removeJob($cron[$id]);
        }
    }

    function changeConfig()
    {
        $name = input()->value('name');
        $campaign_config_file = ROOT_PATH . "/config/auto-manga-$name.json";

        $default_config = json_decode(file_get_contents(ROOT_PATH . '/config/auto-manga.json'), true);
        $private_config = [];


        foreach ($default_config as $config_key => $config_value) {
            $private_config[$config_key] = input()->value($config_key, $config_value);
        }

        file_put_contents($campaign_config_file, json_encode($private_config, JSON_FORCE_OBJECT));

        response()->json([
            'status' => true
        ]);
    }

    function addQueue()
    {
        $source = input()->value('source');
        if (empty($source) || !class_exists("\\Crawler\\$source")) {
            response()->json([
                'status' => false,
                'msg' => 'Source not vaild!'
            ]);
        }
        $urls = input()->value('urls');

        if (!empty($urls) && is_array($urls)) {
            $urls = array_unique(array_filter($urls));

            foreach ($urls as $url) {
                if (Model::getDB()->where('url', $url)->getValue('crawl_queue', 'id')) {
                    continue;
                }

                Model::getDB()->insert('crawl_queue', [
                    'url' => $url,
                    'source' => $source
                ]);
            }


        }

        $this->run("$this->php_path bin/console auto:queue");
        response()->json(['status' => true]);
    }

    function ajaxTemplate($template)
    {
        $view = "autosite.template.$template";
        $blade = (new Blade());

        if (!$blade->exists($view)) {
            response()->httpCode(404)->json([
                'msg' => "$template not exists!"
            ]);
        }

        return (new Blade())->render($view, [
            'tool_config' => $this->tool_config,
        ]);
    }

    function run($command, $outputFile = '/dev/null')
    {
        // windows

        if (substr(php_uname(), 0, 7) == "Windows") {
            pclose(popen("start /B " . $command, "r"));
            // linux
        } else {
            exec(
                sprintf(
                    '%s > %s &',
                    $command,
                    $outputFile
                )
            );
        }
    }
}