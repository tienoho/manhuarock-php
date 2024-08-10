<?php

namespace Config;

class Cache extends Config
{
    // New update list in home
    const CACHE_PATH = ROOT_PATH . '/resources/cache'; // or in windows "C:/tmp/"

    const NEW_UPDATE_LIST = 3600;

    const POPULAR_LIST = 3600; // 5min
}
