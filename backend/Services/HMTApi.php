<?php

namespace Services;


class HMTApi
{
    public $config;

    public function __construct()
    {
        $this->config = getConf('hmt-api');

    }

    function upload($data, $path_to_upload)
    {
        $post = [
            'data' => $data,
            'path' => $path_to_upload,
        ];

        $ch = curl_init($this->config->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $response = curl_exec($ch);
        $response = json_decode($response);
        curl_close($ch);

        if(isset($response['status'])){
            return $this->config->cdn_url . trim($path_to_upload, '/');
        }

        exit("Lỗi khi upload");
    }

    function delete()
    {

    }
}