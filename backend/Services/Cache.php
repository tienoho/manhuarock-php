<?php

namespace Services;

use Config\Cache as ConfigCache;
use Phpfastcache\CacheManager;
use Phpfastcache\Core\Pool\ExtendedCacheItemPoolInterface;
use Phpfastcache\Drivers\Files\Config as FilesConfig;
use Phpfastcache\Drivers\Redis\Config as RedisConfig;

class Cache
{
    public static $getInstance;
    public static $type = 'files';

    public static function load($path = ConfigCache::CACHE_PATH, $securityKey = 'manga'): ExtendedCacheItemPoolInterface
    {
        if (self::$getInstance === null) {

            switch (self::$type) {
                case 'files':
                    $driver = "files";
                    $config = new FilesConfig(['path' => $path, 'securityKey' => $securityKey]);
                    $config->setDefaultChmod(0777);

                    break;
                case 'redis':
                    $driver = 'redis';
                    $config = new RedisConfig([
                        'host' => '127.0.0.1', //Default value
                        'port' => 6379, //Default value
                        'password' => '', //Default value
                        'database' => '', //Default value
                        'path' => $path
                    ]);
                    break;
            }

            $config->setDefaultFileNameHashFunction('md5');
            $config->setCompressData(true);

            self::$getInstance = CacheManager::getInstance($driver, $config);
        }

        return self::$getInstance;
    }


}