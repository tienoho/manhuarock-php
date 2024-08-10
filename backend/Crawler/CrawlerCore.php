<?php

namespace Crawler;

use GuzzleHttp\Client;

class CrawlerCore
{
    public $proxy = true;
    public $referer = 'https://google.com/';
    public $headers = [];

    public $options = [
        'headers' => [
        ],
        
        'curl' => [
//            CURLOPT_RESOLVE => 'www.google.com:443:173.194.72.112'
        ]
    ];

    public function __construct()
    {
        if (empty($this->options['headers'])) {
            $this->options['headers'] = [
                'referer' => $this->referer
            ];
        }

        $this->int();
    }

    public function int()
    {
        $this->options = [
            'headers' => [
                'referer' => $this->referer,
                'user-agent' => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36",
            ]
        ];

        $this->client = new Client([
            "request.options" => array(
                $this->options,
            ),
        ]);
    }

    public $BLACK_LIST = [];

    function curl($url)
    {
        $isRunning = true;
        $proxys = getConf('proxy') ?? [];
        $current_proxy = 0;
        while ($isRunning) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);

            $headers = array(
                "referer: $this->referer",
                "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36",
            );

            $headers = array_merge($headers, $this->headers);

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            if ($proxys && $current_proxy < (count($proxys) - 1)) {
                $proxy = trim($proxys[$current_proxy]);
                print_r($proxy . "\n");

                curl_setopt($curl, CURLOPT_PROXY, $proxy);
            }

            $resp = curl_exec($curl);

            if (!curl_error($curl) || $current_proxy > count($proxys)) {
                $isRunning = false;
            } else {
                echo curl_error($curl);
            }

            curl_close($curl);
            $current_proxy++;
        }

        return $resp;
    }

    function bypass($url)
    {
        return $this->curl($url);
    }

    function isBlacklist($name)
    {
        foreach ($this->BLACK_LIST as $blockItem) {
            if ($blockItem == $name) {
                return true;
            }
        }

        return false;
    }

    function setType()
    {

    }

    function minifier($code)
    {
        $search = array(

            // Remove whitespaces after tags
            '/\>[^\S ]+/s',

            // Remove whitespaces before tags
            '/[^\S ]+\</s',

            // Remove multiple whitespace sequences
            '/(\s)+/s',

            // Removes comments
            '/<!--(.|\s)*?-->/'
        );
        $replace = array('>', '<', '\\1');
        return preg_replace($search, $replace, $code);
    }

    function post($url)
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }

    function strip_word_html($text, $allowed_tags = '<ul><li><b><i><sup><sub><em><strong><u><br><br/><br /><p><h2><h3><h4><h5><h6>')
    {
        mb_regex_encoding('UTF-8');
        //replace MS special characters first
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        //make sure _all_ html entities are converted to the plain ascii equivalents - it appears
        //in some MS headers, some html entities are encoded and some aren't
        //$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        //try to strip out any C style comments first, since these, embedded in html comments, seem to
        //prevent strip_tags from removing html comments (MS Word introduced combination)
        if (mb_stripos($text, '/*') !== FALSE) {
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
        //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be
        //'<1' becomes '< 1'(note: somewhat application specific)
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        //strip out inline css and simplify style tags
        $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
        $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears
        //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains
        //some MS Style Definitions - this last bit gets rid of any leftover comments */
        $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        if ($num_matches) {
            $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
        }
        $text = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $text);
        return $text;
    }


    function getTranslate($url, $bunny = ""){
        $url = htmlspecialchars_decode($url);

        if(!str_contains($url, '_x_tr_sl')){
            $parse_url = parse_url($url);
            $host = str_replace('.', '-', $parse_url['host']);
            $path = $parse_url['path'] ?? "/";
            $query = isset($parse_url['query']) ? $parse_url['query'] . '&' : '';

            $url = sprintf(
                "https://%s.translate.goog%s?%s_x_tr_sl=en&_x_tr_tl=vi&_x_tr_hl=en&_x_tr_pto=op,wapp",
                $host,
                $path,
                $query
            );
        }

        if(!empty($bunny)){
            $host = parse_url($url, PHP_URL_HOST);
            $url = str_replace($host, $bunny, $url);
        }

        return $url;
    }

    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = \strpos($string, $start);
        if ($ini == 0)
            return '';
        $ini += \strlen($start);
        $len = \strpos($string, $end, $ini) - $ini;
        return \substr($string, $ini, $len);
    }
}