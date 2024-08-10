<?php

namespace Controllers;

use Config\Config;
use Config\Seo;
use L;
use Models\Manga as MangaModel;
use Models\Model;
use Models\Taxonomy;
use Services\Blade;

class Page
{
    public function test(){
        print_r((new \ImageProxy())->getProxy2("https://cdn.vncomic.net/images/852101844339261440/852158847312330792/3.jpg"));
    }

    public function notFound()
    {

        return (new Blade())->render('themes.' . app_theme() . '.pages.404');
    }

    public function history(){
        return (new Blade())->render('themes.' . app_theme() . '.pages.history');
    }

    function default($page = 1){
        $manga_model = new MangaModel();
        $manga_model->page = $page;
        $manga_model->limit = getConf('site')['general_page'];
        $manga_model->paginate = true;

        $sort = input()->value('sort', true);

        Model::getDB()->orderBy(getSort($sort));

        $data = $manga_model->manga_list();
        return (new Blade())->render('themes.'. app_theme() .'.pages.manga-list', [
            'mangas' => $data->mangas,
            'paginate' => $data->paginate,
            'page' => $page,
            'sort' => $sort,
            'url' => 'manga_list',
            'params' => ['sort' => $sort],
            'heading_title' => L::_('All Manga'),
            'seo_title' => L::_('All Manga'),
            'breadcrumb' => [
                (object)['name' => L::_('Home'), 'url' => url('home')],
                (object)['name' => L::_('All Manga'), 'url' => null, 'active' => true],
            ]
        ]);

    }
    public function completed($page = 1)
    {
        $sort = input()->value('sort', true);

        $data = (new MangaModel())->completed($page, 16, getSort($sort), true);

        return (new Blade())->render('themes.'. app_theme() .'.pages.manga-list', [
            'mangas' => $data->mangas,
            'paginate' => $data->paginate,
            'page' => $page,
            'sort' => $sort,
            'url' => 'completed',
            'params' => ['sort' => $sort],
            'heading_title' => L::_('Completed Manga'),
            'seo_title' => L::_('Completed Mangas'),
            'breadcrumb' => [
                (object)['name' => L::_('Home'), 'url' => url('home')],
                (object)['name' => L::_('Completed Manga'), 'url' => null, 'active' => true],
            ]
        ]);
      }

    public function newRelease($page = 1){
        $manga_model = new MangaModel();
        $manga_model->page = $page;
        $manga_model->limit = getConf('site')['general_page'];
        $manga_model->paginate = true;

        Model::getDB()->orderBy('mangas.created_at');

        $data = $manga_model->manga_list();

        return (new Blade())->render('themes.'. app_theme() .'.pages.manga-list', [
            'mangas' => $data->mangas,
            'paginate' => $data->paginate,
            'page' => $page,
            'sort' => false,
            'url' => 'new-release',
            'params' => null,
            'heading_title' =>  L::_('New Release'),
            'seo_title' => L::_('New Release List'),
            'breadcrumb' => [
                (object)['name' => L::_('Home'), 'url' => url('home')],
                (object)['name' => L::_('New Release'), 'url' => null, 'active' => true],
            ]
        ]);
    }

    public function latestUpdated($page = 1){
        $manga_model = new MangaModel();
        $manga_model->page = $page;

        $manga_model->limit = getConf('site')['general_page'];
        $manga_model->paginate = true;

        Model::getDB()->orderBy('mangas.last_update');

        $data = $manga_model->manga_list();

        return (new Blade())->render('themes.'. app_theme() .'.pages.manga-list', [
            'mangas' => $data->mangas,
            'paginate' => $data->paginate,
            'page' => $page,
            'sort' => false,
            'url' => 'latest-updated',
            'params' => null,
            'heading_title' => L::_('Latest Updated'),
            'seo_title' => L::_('Latest Updated MANGA'),
            'breadcrumb' => [
                (object)['name' => L::_('Home'), 'url' => url('home')],
                (object)['name' => L::_('Latest Updated'), 'url' => null, 'active' => true],
            ]
        ]);
    }

    public function mostViewed($page = 1){
        $manga_model = new MangaModel();
        $manga_model->page = $page;
        $manga_model->limit = getConf('site')['general_page'];
        $manga_model->paginate = true;

        Model::getDB()->orderBy('mangas.views');

        $data = $manga_model->manga_list();

        return (new Blade())->render('themes.'. app_theme() .'.pages.manga-list', [
            'mangas' => $data->mangas,
            'paginate' => $data->paginate,
            'page' => $page,
            'sort' => false,
            'url' => 'most-viewed',
            'params' => null,
            'heading_title' => L::_('Most Viewed'),
            'seo_title' => L::_('Most Viewed'),
            'breadcrumb' => [
                (object)['name' => L::_('Home'), 'url' => url('home')],
                (object)['name' => L::_('Most Viewed'), 'url' => null, 'active' => true],
            ]
        ]);
    }

    public function mangaType($type, $page = 1){
        $manga_model = new MangaModel();
        $manga_model->page = $page;
        $manga_model->limit = getConf('site')['general_page'];
        $manga_model->paginate = true;
        $sort = input()->value('sort', true);
        $type_name = type_name($type);

        Model::getDB()->orderBy(getSort($sort));
        Model::getDB()->where('mangas.type', $type);

        $data = $manga_model->manga_list();

        return (new Blade())->render('themes.'. app_theme() .'.pages.manga-list', [
            'mangas' => $data->mangas,
            'paginate' => $data->paginate,
            'page' => $page,
            'sort' => $sort,
            'url' => 'manga.type',
            'params' => ['sort' => $sort],
            'heading_title' => $type_name,
            'seo_title' => 'Danh Sách '. $type_name,
            'breadcrumb' => [
                (object)['name' => L::_('Home'), 'url' => url('home')],
                (object)['name' => 'Type', 'url' => url()],
                (object)['name' => $type_name, 'url' => null, 'active' => true],
            ]
        ]);
    }

    public function search($page = 1){
        $manga_model = new MangaModel();
        $manga_model->page = $page;
        $manga_model->limit = getConf('site')['general_page'];
        $manga_model->paginate = true;
        $keyword = input()->value('keyword');


        Model::getDB()->orderBy('mangas.name');

        if(!empty($keyword)){
            Model::getDB()->where('mangas.name', "%$keyword%", 'LIKE');
            Model::getDB()->orWhere('mangas.other_name', "%$keyword%", 'LIKE');
            Model::getDB()->orWhere('mangas.slug', "%".slugGenerator($keyword)."%", 'LIKE');
        }


        $data = $manga_model->manga_list();

        return (new Blade())->render('themes.'. app_theme() .'.pages.manga-list', [
            'mangas' => $data->mangas,
            'paginate' => $data->paginate,
            'page' => $page,
            'sort' => false,
            'url' => 'search',
            'params' => ['keyword' => $keyword],
            'heading_title' => sprintf(L::_('Search for: %s'), $keyword),
            'seo_title' => 'Tìm Truyện '. $keyword,
            'breadcrumb' => [
                (object)['name' => L::_('Home'), 'url' => url('home')],
                (object)['name' => 'Search', 'url' => null, 'active' => true],
            ]
        ]);
    }

    public function filter($page = 1){
        $type = input()->value('type');
        $status = input()->value('status');
        $sort = input()->value('sort');
        $genres = input()->value('genres');

        $manga_model = new MangaModel();
        $manga_model->page = $page;
        $manga_model->limit = getConf('site')['general_page'];
        $manga_model->paginate = true;

        Model::getDB()->orderBy(getSort($sort));

        if(in_array($status, array_keys(allStatus()))){
            Model::getDB()->where('mangas.status', $status);
        }

        if(in_array($status, array_keys(allComicType()))){
            Model::getDB()->where('mangas.type', $type);
        }

        if(!empty($genres)){
            $genres = explode(',', ($genres));

            foreach ($genres as $genre_id){
                $taxonomy_manga_key = 'taxonomy_manga'. $genre_id;
                $taxonomy_key = 'taxonomy'. $genre_id;

                Model::getDB()->join("taxonomy_manga $taxonomy_manga_key", "$taxonomy_manga_key.manga_id=mangas.id");
                Model::getDB()->join("taxonomy $taxonomy_key", "$taxonomy_key.id=$taxonomy_manga_key.taxonomy_id");
                Model::getDB()->joinWhere("taxonomy $taxonomy_key", "$taxonomy_key.taxonomy",'genres');
                Model::getDB()->joinWhere("taxonomy_manga $taxonomy_manga_key", "$taxonomy_manga_key.taxonomy_id", $genre_id);
            }

            Model::getDB()->groupBy('mangas.id');
        }

        $data = $manga_model->manga_list();

        return (new Blade())->render('themes.'. app_theme() .'.pages.filter', [
            'filter_list' => $data->mangas,
            'paginate' => $data->paginate,
            'params' => [
                'type' => $type,
                'sort' => $sort,
                'status' => $status,
                'genres' => $genres,
            ],
            'type' => $type,
            'sort' => $sort,
            'status' => $status,
            'genres' => $genres,
            'url' => 'filter'
        ]);
    }

    public function genres($slug, $page = 1): string
    {
        $manga_model = new MangaModel();
        $manga_model->page = $page;
        $manga_model->limit = getConf('site')['general_page'];
        $manga_model->paginate = true;

        $sort = input()->value('sort', true);

        Taxonomy::getDB()->where('slug', $slug);
        Taxonomy::getDB()->where('taxonomy', 'genres');
        $Taxonomy = Taxonomy::getDB()->objectBuilder()->getOne('taxonomy', 'name');

        if(empty($Taxonomy)){
            response()->redirect(url('404'));
        };


        Model::getDB()->orderBy(getSort($sort));

        Model::getDB()->join('taxonomy_manga', 'taxonomy_manga.manga_id=mangas.id');

        Model::getDB()->join('taxonomy', 'taxonomy_manga.taxonomy_id=taxonomy.id');
        Model::getDB()->joinWhere('taxonomy', 'taxonomy.taxonomy','genres');
        Model::getDB()->joinWhere('taxonomy', 'taxonomy.slug', $slug);

        $data = $manga_model->manga_list();

        return (new Blade())->render('themes.'. app_theme() .'.pages.manga-list', [
            'mangas' => $data->mangas,
            'paginate' => $data->paginate,
            'page' => $page,
            'sort' => $sort,
            'url' => 'genres',
            'params' => ['sort' => $sort],
            'heading_title' => $Taxonomy->name,
            'seo_title' => $Taxonomy->name,
            'breadcrumb' => [
                (object)['name' => L::_('Home'), 'url' => url('home')],
                (object)['name' => 'Genres', 'url' => url()],
                (object)['name' => $Taxonomy->name, 'url' => null, 'active' => true],
            ]
        ]);
    }

    public function authors($slug, $page = 1): string
    {
        $manga_model = new MangaModel();
        $manga_model->page = $page;
        $manga_model->limit = getConf('site')['general_page'];
        $manga_model->paginate = true;

        $sort = input()->value('sort', true);

        Taxonomy::getDB()->where('slug', $slug);
        Taxonomy::getDB()->where('taxonomy', 'authors');

        $Taxonomy = Taxonomy::getDB()->objectBuilder()->getOne('taxonomy', 'name');
        if(empty($Taxonomy)){
            response()->redirect(url('404'));
        }

        Model::getDB()->orderBy(getSort($sort));

        Model::getDB()->join('taxonomy_manga', 'taxonomy_manga.manga_id=mangas.id');
        Model::getDB()->join('taxonomy', 'taxonomy_manga.taxonomy_id=taxonomy.id');
        Model::getDB()->joinWhere('taxonomy', 'taxonomy.slug', $slug);

        $data = $manga_model->manga_list();

        return (new Blade())->render('themes.'. app_theme() .'.pages.manga-list', [
            'mangas' => $data->mangas,
            'paginate' => $data->paginate,
            'page' => $page,
            'sort' => $sort,
            'url' => 'authors',
            'params' => ['sort' => $sort],
            'heading_title' => $Taxonomy->name,
            'seo_title' => $Taxonomy->name,
            'breadcrumb' => [
                (object)['name' => L::_('Home'), 'url' => url('home')],
                (object)['name' => 'Authors', 'url' => url()],
                (object)['name' => $Taxonomy->name, 'url' => null, 'active' => true],
            ]
        ]);


    }

    public function artists($slug, $page = 1): string
    {
        $manga_model = new MangaModel();
        $manga_model->page = $page;
        $manga_model->limit = getConf('site')['general_page'];
        $manga_model->paginate = true;

        $sort = input()->value('sort');

        Taxonomy::getDB()->where('slug', $slug);
        Taxonomy::getDB()->where('taxonomy', 'artists');
        $Taxonomy = Taxonomy::getDB()->objectBuilder()->getOne('taxonomy', 'name');
        Model::getDB()->orderBy(getSort($sort));

        Model::getDB()->join('taxonomy_manga', 'taxonomy_manga.manga_id=mangas.id');
        Model::getDB()->join('taxonomy', 'taxonomy_manga.taxonomy_id=taxonomy.id');
        Model::getDB()->joinWhere('taxonomy', 'taxonomy.taxonomy','artists');
        Model::getDB()->joinWhere('taxonomy', 'taxonomy.slug', $slug);

        $data = $manga_model->manga_list();

        return (new Blade())->render('themes.'. app_theme() .'.pages.manga-list', [
            'mangas' => $data->mangas,
            'paginate' => $data->paginate,
            'page' => $page,
            'sort' => $sort,
            'url' => 'artists',
            'params' => ['sort' => $sort],
            'heading_title' => $Taxonomy->name,
            'seo_title' => 'Truyện Của Nhóm Dịch '. $Taxonomy->name,
            'breadcrumb' => [
                (object)['name' => L::_('Home'), 'url' => url('home')],
                (object)['name' => L::_('Translation'), 'url' => url()],
                (object)['name' => $Taxonomy->name, 'url' => null, 'active' => true],
            ]
        ]);

    }

    public function terms(){
        $blable = new Blade;
        return $blable->render('themes.' . app_theme() . '.pages.terms');
    }

    public function dmca(){
        $blable = new Blade;
        return $blable->render('themes.' . app_theme() . '.pages.dmca');
    }

    public function contact(){
        $blable = new Blade;
        return $blable->render('themes.' . app_theme() . '.pages.contact');
    }

    public function requestPermission(){

        $blable = new Blade;
        return $blable->render('themes.' . app_theme() . '.pages.request-detail');
    }
}