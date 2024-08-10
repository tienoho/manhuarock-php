<?php

namespace Services;

use Google\Client;
use Google\Service\Oauth2;

class GoogleLogin {
    public $client;
    public $config = [];

    function __construct(){
        $this->config = getConf('google-login');
        $site_url = getConf('site')['site_url'];


        $this->client = new Client();

        $this->client->setAuthConfig($this->config['client_secret']);

        $this->client->setRedirectUri($site_url);
        $this->client->addScope('email');
        $this->client->addScope('profile');
    }

    function getAuthUrl(){
        return $this->client->createAuthUrl();
    }

    function getAccessToken(){
        return $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
    }

    function getUserInfo(){
        $this->client->setAccessToken($this->getAccessToken());

        $oauth2 = new Oauth2($this->client);
        return $oauth2->userinfo->get();
    }
}

