<?php

namespace Controllers;

use Models\Model;
use Services\Blade;

class Rss {
    function index(){
        $page = input()->value('page', 1);
        $limit = 30;

        $manga_rss = Model::getDB()
            ->orderBy('last_update')
            ->objectBuilder()
            ->get('mangas', 20, 'name, id, slug, description, other_name');

        header('Content-Type: text/xml; charset=utf-8');

        return (new Blade())->render('rss', [
            'manga_rss' => $manga_rss
        ]);
    }
}
