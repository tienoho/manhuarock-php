<?php

namespace Services;

use Ausi\SlugGenerator\SlugGenerator;

interface CrawlerInterface {
    public function list($page);
    public function info($url);
    public function content($url);
}

class AutoManga
{
    /** @var CrawlerInterface */
    public $crawler;

    /** @var \Predis\Client */
    public $redis;

    /** @var \Services\StorageDriver\StorageDriverInterface */
    public $storage_driver;
    public $manga;
    public $current_url;
    public $config;

    public function __construct()
    {
        // Get config
        $this->config = include ROOT_PATH . '/config/tools-v2/config.php';

        // Get redis
        $this->redis = $this->config['redis'];

        $this->storage_driver = $this->config['storage_driver'];
    }

    public function setCrawler($crawler)
    {
        $this->crawler = $crawler;
    }

    public function getMangas($page)
    {
        $urls = $this->crawler->list($page);
        foreach ($urls as $url) {
            $this->saveManga($url);
        }
    }

    public function saveManga($url)
    {

        $manga = $this->crawler->info($url);

        if (!$manga) {
            return false;
        }

        $this->current_url = $url;
        $this->manga = $manga;
        $this->manga['slug'] = slugGenerator($manga['name']);

        $manga_id = $this->getMangaId();

        $this->detectType();

        if (!$manga_id) {
            $this->manga['cover'] = $this->getCover();

            $manga_id = $this->insertManga();
        }

        echo $manga_id;

        print_r($this->manga);

        $this->manga = [];
        $this->current_url = '';
    }

    public function getMangaId()
    {
        $url = $this->current_url;

        $key = "manga:{$url}";

        // $exist = $this->redis->exists($key) ;

        $exist = false;

        if (!$exist) {
            $db = \Models\Model::getDB();

            $db->where('name', $this->manga['name']);
            $db->orWhere('slug', $this->manga['slug']);

            if (isset($this->manga['other_name'])) {
                $db->where('other_name', $this->manga['other_name']);
            }

            $db->where('other_name', $this->manga['name']);

            $manga_id = $db->getValue('mangas', 'id');

            if (!empty($manga_id)) {
                $this->redis->set($key, $manga_id);
                $this->redis->expire($key, 86400);

                return $manga_id;
            }

            return false;
        }

        return $this->redis->get($key);
    }

    public function insertManga()
    {
        $db = \Models\Model::getDB();

        $db->insert('mangas', [
            'name' => $this->manga['name'],
            'slug' => $this->manga['slug'],
            'other_name' => $this->manga['other_name'] ?? NULL,
            'description' => $this->manga['description'] ?? NULL,
            'cover' => $this->manga['cover'] ?? NULL,
            'status' => $this->manga['status'] ?? 'on-going',
            'adult' => isset($this->manga['adult']) ? 1 : 0,
            'type' => $this->manga['type'] ?? NULL,
            'hidden' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'last_update' => date('Y-m-d H:i:s'),
        ]);

        $manga_id = $db->getInsertId();

        $this->redis->set("manga:{$this->current_url}", $manga_id);

        return $manga_id;
    }


    public function getCover()
    {
        $cover_url = $this->manga['cover'];

        if (empty($cover_url)) {
            return false;
        }

        $client = new \GuzzleHttp\Client();
        $http_options = $this->crawler->options;

        $response = $client->request('GET', $cover_url, $http_options);

        $body = $response->getBody();
        $cover = $body->getContents();

        $this->storage_driver->put("covers/{$this->manga['slug']}.jpg", $cover);

        return $this->storage_driver->getUrl();
    }
    

    function detectType()
    {
        if (isset($this->manga['taxonomy']['genres']) && is_array($this->manga['taxonomy']['genres'])) {
            $genres = $this->manga['taxonomy']['genres'] ?? [];

            foreach ($genres as $genre) {
                if (str_contains('Manga', $genre)) {
                    $this->manga['type'] = 'manga';
                    break;
                }

                if (str_contains('Manhua', $genre)) {
                    $this->manga['type'] = 'manhua';
                    break;
                }

                if (str_contains('Manhwa', $genre)) {
                    $this->manga['type'] = 'manhwa';
                    break;
                }

                if (str_contains('One', $genre)) {
                    $this->manga['type'] = 'one-shot';
                    break;
                }
            }
        }
    }
}
