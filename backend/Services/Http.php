<?php

namespace Services;

class Http
{
    public static $source;
    public static $status;
    public static $headers;
    public static $referer;
    private static $instance;

    public static function int()
    {
        $header = array();
        $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
        $header[] = 'Cache-Control: max-age=0';
        $header[] = 'Content-Type: text/html; charset=utf-8';
        $header[] = 'Transfer-Encoding: chunked';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Keep-Alive: 300';
        $header[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
        $header[] = 'Accept-Language: en-us,en;q=0.5';
        $header[] = 'Pragma:';

        self::$referer = 'https://www.google.com';
        self::$headers = $header;
    }

    public static function setHeaders($headers)
    {
        self::$headers = $headers;
    }

    public static function setReferer($referer)
    {
        self::$referer = $referer;
    }

    public static function get(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +https://www.google.com/bot.html)');
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::$headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_REFERER, self::$referer);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        self::$source = curl_exec($ch);
        self::$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function response()
    {
        return self::$source;
    }

    public static function getStatus()
    {
        return self::$status;
    }

    public static function isSuccess()
    {
        return self::$status == 200;
    }

    public static function showError()
    {
        $error_message = 'Terjadi kesalahan';

        if (self::$status >= 500) {
            $error_message = 'Server Error';
        } else if (self::$status == 404) {
            $error_message = 'Data tidak ditemukan';
        } else if (self::$status >= 400) {
            $error_message = 'Client Error';
        }

        return ['status' => strtoupper(str_replace(' ', '_', $error_message)), 'status_code' => self::$status, 'message' => $error_message,];
    }
}
