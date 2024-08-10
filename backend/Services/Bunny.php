<?php

namespace Services;

class Bunny
{
    public static $client;
    public static $config;

    public function __construct()
    {
        if (!self::$client) {
            self::$client = new \GuzzleHttp\Client();
        }

        if (!self::$config) {
            self::$config = json_decode(file_get_contents(ROOT_PATH . '/config/bunny.json'));
        }
    }

    function upload($data, $path_to_upload)
    {
        $path_to_upload = trim($path_to_upload, '/');

        $response = self::$client->request('PUT', "https://storage.bunnycdn.com/" . self::$config->Storage . "/$path_to_upload", [
            'body' => $data,
            'headers' => [
                'AccessKey' => self::$config->AccessKey,
                'Content-Type' => 'application/octet-stream',
            ],
        ]);

        if (json_decode($response->getBody())->Message === "File uploaded.") {
            return self::$config->cdn_url . "/$path_to_upload";
        }

        exit("Lỗi khi upload");
    }

    function delete()
    {

    }
}