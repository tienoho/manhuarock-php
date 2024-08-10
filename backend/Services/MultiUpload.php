<?php 

namespace Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;

class MultiUpload {
    protected array $commands = [];
    protected array $uploaded = [];
    protected string $api;
    protected Client $client;

    protected $multipart_name;
    protected $fulfilled;

    protected $extenstion = 'png';

    public function __construct($api, $config = ['verify' => false, 'http_errors' => false], $multipart_name = 'data')
    {
        $this->multipart_name = $multipart_name;
        $this->api = $api;
        $this->client = new Client($config);
    }

    /** Example:
         function (Response $response, $index) {
            // this is delivered each successful response
            $content = json_decode($response->getBody()->getContents());
            if (isset($content->status) && $content->status == 1) {
                $this->uploaded[$index] = $content->url;
            }
        }
     * */
    public function setUploadedCallback(callable $fulfilled = null)
    {
        $this->fulfilled = $fulfilled;
    }


    function setUploads($datas)
    {
        foreach ($datas as $data) {
            $this->addUpload($data);
        }

        return $this;
    }

    function uploadFromUrls($urls, $CurlOptions = [])
    {
        $multiCurl = new MultiCurl();
        foreach ($urls as $url) {
            $multiCurl->addUrl($url, $CurlOptions);
        }

        $dowloaded = $multiCurl->exce();
        return $this->setUploads($dowloaded);
    }


    /**
     * @throws \Gumlet\ImageResizeException
     */
    function addUpload($data, $resize = false): void
    {
        if ($resize) {
            $image = ImageResize::createFromString($data);
            $image->resizeToWidth(800);


            $data = $image->getImageAsString();
        }

        $this->commands[] = $this->client->postAsync($this->api, [
            'multipart' => [
                [
                    'name'     => $this->multipart_name,
                    'contents' => $data,
                    'filename' => time() . '.png'
                ]
            ]
        ]);
    }


    function setUploaded($uploaded, $index)
    {
        $this->uploaded[$index] = $uploaded;
    }

    function exce()
    {

        $requests = (function ($commands) {
            foreach ($commands as $command) {
                yield
                    function () use ($command) {
                        return $command;
                    };
            }
        });

        $pool = new Pool($this->client, $requests($this->commands), [
            'concurrency' => 15,
            'fulfilled' => $this->fulfilled,
            'rejected' => function (RequestException $reason, $index) {
                // this is delivered each failed request
                print_r($reason);
            },
        ]);

        $promise = $pool->promise();
        // Force the pool of requests to complete.
        $promise->wait();


        ksort($this->uploaded, SORT_NUMERIC);

        return $this->uploaded;
    }
}