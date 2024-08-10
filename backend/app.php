<?php

const ROOT_PATH = __DIR__ . '/..';
require_once __DIR__ . '/vendor/autoload.php';

use Services\Helper;
use Symfony\Component\Dotenv\Dotenv;

class App
{
    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(ROOT_PATH . '/.env');

        Helper::load();
        L::load();
    }

    public function httpOnly()
    {
        session_start();
        (new Services\Router)->start();
    }
}
