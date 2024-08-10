<?php

namespace Models;

use MysqliDb;

class FlatManga extends Model
{
    public static function getDB()
    {
        return Model::getDB()->connection('flatmanga');
    }
}