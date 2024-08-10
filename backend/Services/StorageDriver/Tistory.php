<?php

namespace Services\StorageDriver;

class Tistory
{

    public $config;
    public $url;

    public $api_url = 'https://anikaka.tistory.com/manage/post/attach.json';

    public $client;

    public function __construct($config = [])
    {
        $cookie_default = 'TSJSESSION=e041f36c39ae7a5522a4a7df23980b29ae1cf69eb35014fa916b9e24a72ef150;
        TSSESSION_KEEP=1;
        TSSESSION=e2cca1d6710d2fbc2957ff0e613da16f60a99610; __T_=1;
        _T_ANO=LK/N21M0KJLRcArzUkFR9dRZ8psw8d4YfRn3trtJ9Qp0ouHzqiwoOFVgkcaGoYGgXFFUtS4oruvtioYn2BTCNR8IJgg2NAUmHvbtZ/1d9rALAAhvMnV0UjQHZDZ03T+h+Tfj8HxUDkDxlgG5+Rn+MZIW0zYuQveGU+5LN+dHV2b/FZGIlwWrETQ3j8YGey3H6YZmgNAg23Li6/JHJz4qY98ne4wwsSqYaXOWs2Cg0gidwd+cH4PfEde1y01005ukx+1ej7iXgcyNGM+eTKSOu3sQ3oU8finSHmUzCAQ/Ydocd1GvaBl+VCG3qjn0I5bhvbLF6RWlDkaLZcRHJ7hmdQ==';

        if (!empty($config['cookie'])) {
            $cookie_default = $config['cookie'];
        }

        $this->config = [
            'http_errors' => false,
            'headers' => [
                'Referer' => 'https://anikaka.tistory.com/manage/post/attach.json',
                'Cookie' => $cookie_default,
                'Connection' => 'keep-alive',
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'Origin' => 'https://anikaka.tistory.com',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko)
                    Chrome/80.0.3987.132 Safari/537.36',
                'Sec-Fetch-Site' => 'same-origin',
                'Sec-Fetch-Mode' => 'cors',
                'Sec-Fetch-Dest' => 'empty',
                'Accept-Language' => 'en-US,en;q=0.9,ko;q=0.8',
            ],
        ];


        $this->client = new \GuzzleHttp\Client($this->config);
    }

    public function put($file_path, $content)
    {
        $response =  $this->client->request('POST', $this->api_url, [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $content,
                    'filename' => basename($file_path),
                ],
            ],
        ]);

        $body = $response->getBody();
        $contents = $body->getContents();
        $json = json_decode($contents, true);

        $this->url = "https://story-img.kakaocdn.net/dn/{$json['key']}/{$json['filename']}";

        return true;
    }

    public function multiPut($files)
    {
        $multiUpload = new \Services\MultiUpload($this->api_url, $this->client, 'file');

        $multiUpload->setUploadedCallback(function (\GuzzleHttp\Psr7\Response $response, $index) use (&$multiUpload) {
            $raw_res = $response->getBody()->getContents();
            $json = json_decode($raw_res);
            $url = "https://story-img.kakaocdn.net/dn/$json->key/$json->filename";

            $multiUpload->setUploaded($url, $index);
        });

        $data_upload = [];

        foreach ($files as $file_path => $content) {
            $data_upload[] = $content;
        }

        return $multiUpload->setUploads($data_upload)->exce();
    }

    public function getUrl()
    {
        return $this->url;
    }
}
