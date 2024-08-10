<?php

namespace Services;

use GuzzleHttp\Client;

class Tiki
{
    public static $config;
    public static $accessToken;
    public static $refreshToken;

    public function __construct()
    {
        if (!self::$config) {
            self::$config = json_decode(file_get_contents(ROOT_PATH . '/config/tiki.json'));
            self::$accessToken = self::$config->accessToken;
        }
    }

    function upload($data)
    {
        $resp = $this->checkToken(self::$accessToken);

        if (json_decode($resp)->active === false) {
            $getToken = $this->getResetToken();
            self::$accessToken = $getToken->accessToken;
            self::$refreshToken = $getToken->refreshToken;

            file_put_contents(ROOT_PATH . '/config/tiki.json', json_encode([
                'accessToken' => self::$accessToken,
                'refreshToken' => self::$refreshToken
            ], JSON_FORCE_OBJECT));
        }

        $img = imagecreatefromstring($data);
        ob_start();
        imagejpeg($img);
        $data = ob_get_contents();
        imagedestroy($img);
        ob_end_clean();

        $guzzle = new Client();

        $raw_response = $guzzle->post('https://api-sellercenter.tiki.vn/titan/v1/uploads', [
            'headers' => [
                'Authorization' => 'Bearer ' . self::$accessToken,
                'Accept' => 'application/json'
            ],
            'multipart' => [
                [
                    'name' => 'files',
                    'contents' => $data,
                    'filename' => uniqid() . '.jpg'

                ]

            ],
            'curl' => [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            ],
        ]);

        $url = explode_by('"url":"', '"', $raw_response->getBody()->getContents());

        if (!$url) {
            exit("Not get url image");
        }

        return $url;
    }

    function getToken()
    {
        $url = "https://account.tiki.vn/api/accounts/get";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $TIKI_GUEST_TOKEN = 'tUTrbxf3DkORoKYjdPAm7ls5eQvM1Cwy';

        $TOKENS = json_encode([
            'access_token' => $TIKI_GUEST_TOKEN,
            'guest_token' => $TIKI_GUEST_TOKEN,
            'expires_in' => 157680000,
            'expires_at' => 1817528319781
        ]);

        $headers = array(
            "cookie: SSO_DEVICE_TOKEN=853c4cd3-07ac-4b9e-98c1-43f275830736;active-customer-id=11532074;  TOKENS=$TOKENS",
            "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36",
            "referer: https://account.tiki.vn/login?username=",
            "accept: application/json, text/plain, */*"
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        if (!$resp) {
            return false;
        }

        $resp = json_decode($resp);

        return $resp->accounts[0];
    }

    function checkToken($token)
    {
        $url = "https://account.tiki.vn/api/accounts/introspect-token";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = '{"token":"' . $token . '"}';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }

    function getResetToken(){
        $url = "https://api.tiki.vn/v3/tokens";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "cookie: SSO_DEVICE_TOKEN=853c4cd3-07ac-4b9e-98c1-43f275830736;",
            "Content-Type: application/json",
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = '{"grant_type":"refresh_token","refresh_token":"TKIA9xCb3x6utrhOjlw5BE-K9qqDIk6Oy1WUgdjqnBkYCyAyK5GFNYz6_3I1pUK3YRJlK6nFvZjM4vQmZZPr","device_id":"d3ae2a5a-364e-0667-b4fb-3c02bd7036f1","is_sso":true,"referer":"https://sellercenter.tiki.vn/"}';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        if (!$resp) {
            return false;
        }
        $resp = json_decode($resp);

        $url = "https://account.tiki.vn/api/accounts/save";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "cookie: SSO_DEVICE_TOKEN=853c4cd3-07ac-4b9e-98c1-43f275830736;",
            "Content-Type: application/json",
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = '{"account":{"customerId":11532074,"accessToken":"'. $resp->access_token .'","refreshToken":"'.  $resp->refresh_token .'"}}';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);


        if (!$resp) {
            return false;
        }

        $resp = json_decode($resp);

        return $resp->accounts[0];
    }
}