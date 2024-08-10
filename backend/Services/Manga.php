<?php

namespace Services;

class Manga
{

    public static $data_path;
    public static $datas;

    public function __construct($custom_path = false)
    {
        self::int($custom_path);
    }

    public static function int($custom_path = false){
        if ($custom_path) {
            self::$data_path = $custom_path;
        }

        if (!self::$data_path) {
            self::$data_path = ROOT_PATH . '/data/manga-info';
        }
    }

    public static function setMangaData($manga_id, $key, $value)
    {
        self::int();


        $data_file_path = sprintf("%s/%s.json", self::$data_path, $manga_id);
        if (!file_exists($data_file_path) && empty(self::$datas[$manga_id])) {
            self::$datas[$manga_id] = (object)[];
        } else {
            $fn = fopen($data_file_path, "r") or die("Unable to open file!");
            $data = fread($fn, filesize($data_file_path));
            fclose($fn);

            self::$datas[$manga_id] = json_decode($data);
        }

        self::$datas[$manga_id]->{$key} = $value;

        if (!is_dir(self::$data_path)) {
            mkdir(self::$data_path, 0777, true);
        }
        file_put_contents($data_file_path, json_encode(self::$datas[$manga_id]));
    }

    public static function getMangaData($manga_id, $key = false, $default = NULL)
    {
        self::int();

        $data_file_path = sprintf("%s/%s.json", self::$data_path, $manga_id);

        if (!isset(self::$datas[$manga_id]) && file_exists($data_file_path)) {
            $fn = fopen($data_file_path, "r") or die("Unable to open file!");
            $data = fread($fn, filesize($data_file_path));
            fclose($fn);

            self::$datas[$manga_id] = json_decode($data);
        }


        if (!$key) {
            return self::$datas[$manga_id];
        }

        return self::$datas[$manga_id]->{$key} ?? $default;
    }


}