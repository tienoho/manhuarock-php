<?php

namespace Services;

use Facebook\Facebook;

class Fb
{

    static $fb;

    function getFB()
    {
        if (!self::$fb) {
            $config = include ROOT_PATH . '/config/fb-login.php';
            self::$fb = new Facebook($config);
        }

        return self::$fb;
    }
}