<?php

namespace Models;

use Config\Manga as MangaConfig;
use Services\Cache;

class Manga extends Model
{
    public static $manga;
    public $page = 1;
    public $limit = null;
    public $fields_def = "mangas.slug, mangas.rating_score, mangas.name, mangas.other_name, mangas.cover, mangas.id, mangas.adult, mangas.views, mangas.created_at, mangas.last_update";
    public $paginate = false;
    public $sort = null;
    public $keyCache = null;
    public $total_comment = false;

    public function count_comment($id)
    {
        if ($this->total_comment === false) {
            $this->total_comment = Model::getDB()->where('manga_id', $id)->getOne('manga_comments', 'COUNT(id) as total')['total'];
        }

        return $this->total_comment;
    }

    public function pin_manga($limit)
    {
        $Cache = Cache::load();
        $CachedString = $Cache->getItem("pin_manga");

        if (!$CachedString->isHit() || getConf('site')['is_cache'] !== 'on') {
            $this->limit = $limit;
            $this->fields_def = "mangas.slug, mangas.name, mangas.cover, mangas.id, mangas.adult, mangas.rating_score, mangas.views, mangas.created_at, mangas.description";
            Model::getDB()->where('mangas.pin', 1);

            $data = $this->manga_list();

            if (getConf('site')['is_cache'] === 'on') {
                $CachedString->set($data)->expiresAfter(getConf('site')['CacheTime']);
                $Cache->save($CachedString);
            }

            return $data;
        }

        return $CachedString->get();
    }

    public function trending_manga($limit)
    {
        $Cache = Cache::load();
        $CachedString = $Cache->getItem("trending_manga_$limit");

        if (!$CachedString->isHit()) {
            $this->limit = $limit;

            Model::getDB()->orderBy('views');

            $data = $this->manga_list();

            $CachedString->set($data)->expiresAfter(5000);
            $Cache->save($CachedString);

            return $data;
        }

        return $CachedString->get();

    }

    public function recommended($limit)
    {
        $this->limit = $limit;
        Model::getDB()->join('chapters', 'mangas.id=chapters.manga_id', 'LEFT');
        Model::getDB()->having("COUNT(chapters.id)", 30, '>=');
        Model::getDB()->groupBy('mangas.id');
        Model::getDB()->orderBy("RAND ()");

        return $this->manga_list();
    }

    public function top_views($views, $limit)
    {
        $this->limit = $limit;

        switch ($views) {
            case 'views':
            case 'views_day':
            case 'views_week':
            case 'views_month':
                break;
            default:
                $views = 'views';
        }

        $Cache = Cache::load();
        $CachedString = $Cache->getItem($views);

        if (!$CachedString->isHit() || getConf('site')['is_cache'] !== 'on') {
            $this->fields_def = "mangas.slug, mangas.last_update, mangas.name, mangas.cover, mangas.id, mangas.adult, mangas.views, mangas.created_at, mangas.description, mangas.$views";

            Model::getDB()->orderBy($views);

            $data = $this->manga_list();

            $CachedString->set($data)->expiresAfter(getConf('site')['CacheTime']);
            $Cache->save($CachedString);

            return $data;
        }

        return $CachedString->get();

    }

    public function completed($page, $limit, $orderBy = 'last_update', $paginate = false)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->paginate = $paginate;

        Model::getDB()->orderBy($orderBy);
        Model::getDB()->where('mangas.status', 'completed');

        return $this->manga_list();
    }

    public function ongoing($page, $limit, $orderBy = 'last_update', $paginate = false)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->paginate = $paginate;

        Model::getDB()->orderBy($orderBy);
        Model::getDB()->where('status', 'on-going');

        return $this->manga_list();
    }

    public function new_manga($page, $limit, $paginate = false)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->paginate = $paginate;

        Model::getDB()->orderBy('id');

        return $this->manga_list();
    }

    public function new_update($page, $limit, $paginate = false)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->paginate = $paginate;

        Model::getDB()->orderBy('last_update');

        return $this->manga_list();
    }

    public function manga_list()
    {
        Model::getDB()->where('mangas.hidden', 0);
        Model::getDB()->objectBuilder();

        if ($this->paginate) {
            Model::getDB()->pageLimit = $this->limit ?? getConf('site')['general_page'];

            $raw_datas = Model::getDB()->paginate("mangas", $this->page, $this->fields_def);
            $data = object();
            $data->paginate = object();
            $data->paginate->total_page = Model::getDB()->totalPages;
            $data->paginate->current_page = $this->page;
            $data->paginate->total_item = Model::getDB()->totalCount;

            $data->mangas = $raw_datas;
        } else {
            $data = Model::getDB()->get("mangas", $this->limit, $this->fields_def);
        }

        return $data;
    }

    public static function MangaByID($id)
    {
        Manga::getDB()->where('mangas.id', $id);
        return self::Manga();
    }

    public static function Manga()
    {
        Manga::getDB()->where('hidden', 0);
        self::$manga = Manga::getDB()->objectBuilder()->getOne('mangas');
        return self::$manga;
    }

    public static function MangaBySlug($slug)
    {
        Manga::getDB()->where('mangas.slug', $slug);
        return self::Manga();
    }

    public function RelatedManga($limit = MangaConfig::RELATED_MANGA)
    {
        $manga_id = self::$manga->id;

        Manga::getDB()->join('taxonomy_manga', 'mangas.id=taxonomy_manga.manga_id');
        Manga::getDB()->joinWhere('taxonomy_manga.taxonomy', 'genres');

        foreach (get_manga_data('genres', $manga_id, []) as $key => $genre) {
            if ($key === 0) {
                Manga::getDB()->joinWhere('taxonomy_manga.taxonomy_id', $genre->id);
            } else {
                Manga::getDB()->joinOrWhere('taxonomy_manga.taxonomy_id', $genre->id);
            }
        }

        $this->limit = $limit;

        Manga::getDB()->orderBy('RAND()');
        Manga::getDB()->groupBy('mangas.name');

        return $this->manga_list();
    }

    public static function UpdateLastChapter($id)
    {
        $last_chapters = Chapter::ChapterListByID($id, 3);

        set_manga_data('chapters', $id, $last_chapters);

        Model::getDB()->where('id', $id)->update('mangas', [
            'last_update' => Model::getDB()->now(),
        ]);
    }

    public static function AddManga($data)
    {
        $data['last_update'] = Model::getDB()->now();

        $id = Manga::getDB()->insert('mangas', $data);

        if (empty($id)) {
            exit(Manga::getDB()->getLastError());
        }

        return $id;
    }

    public static function EditManga($id, $data)
    {
        Manga::getDB()->where('id', $id);

        $data['last_update'] = Model::getDB()->now();

        $update = Manga::getDB()->update('mangas', $data);

        if (Manga::getDB()->getLastError()) {
            return Manga::getDB()->getLastError();
        }

        return $update;
    }

    public static function DeleteManga($id)
    {
        Manga::getDB()->where('id', $id);
        Manga::getDB()->delete('mangas', 1);
    }

    public static function UpdateView($id)
    {
        Manga::getDB()->rawQuery("UPDATE mangas SET views = views + 1, views_day = views_day + 1, views_week = views_week + 1, views_month = views_month + 1 WHERE id = $id");
    }

}