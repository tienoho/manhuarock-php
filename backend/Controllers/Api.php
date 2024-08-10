<?php

namespace Controllers;

use Models\Model;
use Services\CommandBuilder;

class Api
{

    public function ChapterReport()
    {
        $chapter_id = input()->value('chapter_id');
        $content = input()->value('content');

        if (!$chapter_id || !is_numeric($chapter_id)) {
            return;
        }

        $chap = Model::getDB()
            ->where('id', $chapter_id)->getOne('chapters', 'manga_id, name');
        $manga = Model::getDB()->where('id', $chap['manga_id'])->getOne('mangas', 'name');

        Model::getDB()->insert('reported', [
            'content' => json_encode([
                'report_title' => $manga['name'] . ' - ' . $chap['name'],
                'content' => $content,
            ]),
            'reported_id' => $chapter_id,
            'type' => 'chapter_error',
        ]);

        echo Model::getDB()->getLastError();

        response()->json([
            'status' => true,
        ]);
    }

    public function removeReport()
    {
        $report_id = input()->value('report_id');
        if (!$report_id) {
            response()->json(['status' => false]);
        }

        Model::getDB()->where('reported_id', $report_id)->delete('reported');

        response()->json(['status' => true]);
    }

    public function removeCache()
    {
        (new CommandBuilder())->runCommand('php bin/console cache:clear', false);

        response()->json([
            'status' => true,
        ]);
    }

    public function runScraper()
    {
        $site = input()->value('site');
        $response = "";
        
        if (!empty(input()->value('urls'))) {
            
            $urls = trim(input()->value('urls'));
            $urls = explode("\n", $urls);
            
            foreach ($urls as $url) {
                $url = trim($url);
                $cmd = "php bin/console crawl:data $site --url $url --cron 1";
                $response .= (new CommandBuilder())->runCommand($cmd) . "\n";
            }
        } else { 
            
            $page_start = input('start', 1);
            $page_end = input('end', 1);

            $cmd = "php bin/console crawl:data $site --page $page_start --stop $page_end --cron 1";
            $response = (new CommandBuilder())->runCommand($cmd);
        }

        response()->json([
            'status' => true,
            'response' => nl2br($response),
        ]);
    }

    public function addAds()
    {
        $adsPath = ROOT_PATH . '/resources/views/ads';

        $adsArray = [
            'jshead' => 'head',
            'jsbody' => 'body',
            'banner_ngang' => 'banner-ngang',
            'banner_sidebar' => 'banner-sidebar',
        ];

        foreach ($adsArray as $key => $adsItem) {
            if (isset($_POST[$key])) {
                $ads_code = '<?php $code = "' . base64_encode(input()->value($key, "")) . '"; ?>' . " @if(!empty(\$code))\n@section('$adsItem')\n{!!base64_decode(\$code)!!}\n@stop\n@endif";

                file_put_contents($adsPath . "/$adsItem.blade.php", $ads_code);
            }
        }

    }

    public function metaSetting()
    {
        $metas = [
            'site_name' => '',
            'home_title' => \L::_("Home"),
            'home_description' => '',
            'manga_title' => '',
            'manga_description' => '',
            'chapter_title' => '',
            'chapter_description' => '',
        ];

        foreach ($metas as $key => $meta) {
            $metas[$key] = input()->value($key, $meta);
        }

        setConf('meta', $metas);

        response()->json([
            'status' => true,
        ]);
    }

    public function slugSetting()
    {
        $listSlug = [
            'manga',
            'chapter',
            'manga_list',
            'completed',
            'new-release',
            'latest-updated',
            'most-viewed',
            'search',
            'filter',
            'genres',
            'authors',
            'artists',
            'manga-type',
        ];

        foreach ($listSlug as $slug) {
            $slugs[$slug] = input()->value($slug, $slug);
        }

        setConf('slug', $slugs);

        response()->json([
            'status' => true,
        ]);
    }

    public function uploadTmp()
    {
        $image = input()->file('data');
        $is_scramble = input()->value('is_scramble', 'false');


        if (!$image) {
            return;
        }

        $factor = 0.2;

        $file_name = md5(uniqid(rand(), true)) . ($is_scramble != 'false' ? '_scramble' . $factor : '') . '.png';

        $path = ROOT_PATH . '/publish/uploads/tmp/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        require_once ROOT_PATH . '/backend/Services/Image.php';


        if ($is_scramble != 'false') {
            $keys = getSilices('encrypted');

            $imgHandle = imagecreatefromstring($image->getContents());

            $encrypted_img = encrypt($imgHandle, $keys, $factor);

            myImageSave($encrypted_img, $path . $file_name);
        } else {
            $image->move($path . $file_name);
        }

        response()->json([
            'url' => getConf('site')['site_url'] . '/uploads/tmp/' . $file_name,
        ]);
    }

}