<?php

class listSite
{
    protected $arrayImage = [];
    protected $site;
    protected $fsSessionManager;

    public function __construct()
    {
        $this->fsSessionManager = new fsSessionManager();
    }

    public function truyenqqvn($url) // đổi tên miền ở đây
    {
        $response = $this->fsSessionManager->getContent($url);
        $string = '';
        if ($response !== false) {
            $json_response = json_decode($response, true);
            if ($json_response['status'] == 'ok') {
                $string = $json_response['solution']['response'];
            }
        }
        preg_match_all('#<img class="lazy" src="(.*)"#imsU', $string, $imageList);
        if (!empty($imageList[1])) {
            return $imageList[1];
        }
    }

    private function sliceSite($url)
    {
        preg_match('/https?:\/\/(?:www\.)?(.+?)\./is', $url, $domainName);
        if ($domainName) {
            return $domainName[1];
        }
    }

    public function getValue($url)
    {

        $this->site = $this->sliceSite($url);
        if (preg_match('#truyenqq#is', $this->site)) {
            $this->site = 'truyenqqvn';
        }
        if (!method_exists($this, $this->site)) {
            return;
        }

        $this->arrayImage = call_user_func([$this, $this->site], $url);

        return $this->arrayImage;
    }
}
