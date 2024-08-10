<?php

namespace Models;

use Exception;
use MysqliDb;
use Config\Config;
use Services\Cache;

abstract class Model
{

    public static $db = NULl;
    public $cache;

    public function __construct()
    {
        //        $this->cache = Cache::load();
    }

    protected static function ConCatSelect($columns, $spectator, $orderBy, $newName = null, $limit = 2)
    {
        if (is_array($columns)) {
            $newSlectedColumn = [];
            foreach ($columns as $key => $column) {
                if ($limit) {
                    $newSlectedColumn[] = "substring_index(group_concat(DISTINCT $key ORDER BY $orderBy SEPARATOR '$spectator'), '$spectator', $limit) as $column";
                } else {
                    $newSlectedColumn[] = "group_concat(DISTINCT $key ORDER BY $orderBy SEPARATOR '$spectator') as $column";
                }
            }

            return implode(',', $newSlectedColumn);
        }
        return "substring_index(group_concat($columns SEPARATOR '$spectator'), '$spectator', $limit) as $newName";
    }

    public static function SqlMode()
    {
        static::getDB()->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
    }

    /**
     * Get the Mysql database connection
     *
     * @return MysqliDb
     * @throws Exception
     */

    public static function getDB()
    {
        if (!static::$db) {
            $db_config = getConf('database');

            static::$db = new MysqliDb($db_config['DB_HOST'], $db_config['DB_USER'], $db_config['DB_PASSWORD'], $db_config['DB_NAME'], $db_config['DB_PORT']);

            if ($db_config['DB_PREFIX']) {
                static::$db->setPrefix($db_config['DB_PREFIX']);
            }
        }

        return static::$db;
    }

    public function __destruct()
    {
        static::getDB()->disconnectAll();
    }
}
