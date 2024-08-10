<?php

use Services\Router;

Router::get('/proxy', function () {
    $encode_url = input()->value('data');

    $decode = base64_decode($encode_url, 'd');

    $decode = explode('|', $decode);

    $site = $decode[0];
    $url = $decode[1];

    $class = "\\Crawler\\$site";
    if (!class_exists($class)) {
        exit("Not a valid Proxy");
    }

//    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
//        die('Not a valid URL');
//    }

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) or isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
        @header('HTTP/1.1 304 Not Modified');
        exit;
    }

    @header('Content-type: image/jpeg');
    @header("Cache-Control: public");
    @header('Cache-Control: max-age=86400');
    @header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));

    $crawl = (new $class);
    $image_data = $crawl->curl($url);
    if (isset($crawl->scramble)) {
        $ex = explode('/', $url);
        $photo_id =  str_replace('.jpg', '', end($ex));
        $chapter_id = ($ex[count($ex) - 2]);

        $slice = get_slice($chapter_id, $photo_id);

        $image_data = build_image($image_data, $slice);
    }

    echo $image_data;

}, ['as' => 'proxy']);
