<?php

use Config\Config;
use Languages\lang;
use Services\Cache;

class L
{
    protected static $_L = array();

    public static function load()
    {
        if (empty(self::$_L)) {
            $lang = getConf('site')['lang'];
            $theme = app_theme();

            $file_lang = ROOT_PATH . "/resources/lang/{$theme}/lang.{$lang}.php";
            if (file_exists($file_lang)) {
                require_once(ROOT_PATH . "/resources/lang/{$theme}/lang.{$lang}.php");
                self::$_L = lang::$_L;
            }
        }
    }

    public static function _($phrase)
    {
        return (!array_key_exists($phrase, self::$_L)) ? $phrase : self::$_L[$phrase];
    }
}
