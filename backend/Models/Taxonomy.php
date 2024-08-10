<?php

namespace Models;
use Phpfastcache\Exceptions\PhpfastcacheInvalidArgumentException;
use Services\Cache;
use Exception;

class Taxonomy extends Model {
    public static function GetTaxonomyManga($manga_id, $taxonomy){
        $db = Taxonomy::getDB();
        $db->where('tax.manga_id', $manga_id);
        $db->join("taxonomy txm","txm.id=tax.taxonomy_id", 'LEFT');
        $db->joinWhere('taxonomy txm','txm.taxonomy', $taxonomy);
        $db->objectBuilder();

        return $db->get('taxonomy_manga tax', null, "txm.name, txm.slug, txm.id");
    }

    public static function GetALLTaxonomyManga($manga_id){
        $db = Taxonomy::getDB();
        $db->where('tm.manga_id', $manga_id);

        $db->join("taxonomy t","t.id=tm.taxonomy_id", 'LEFT');

        $db->objectBuilder();

        $datas = $db->get('taxonomy_manga tm', null, "t.name, t.slug, t.id, t.taxonomy");

        $taxonomys = [];
        foreach($datas as $data){
            $taxonomys[$data->taxonomy][] = $data;
        }

        return $taxonomys;
    }

    /**
     * Lấy ID authors & tạo mới nếu authors không tồn tại
     * @param string $taxonomy
     * @param array $taxonomys
     * @param $manga_id
     * @return void ids of authors
     * @throws PhpfastcacheInvalidArgumentException
     */

    public static function SetTaxonomy(string $taxonomy, array $taxonomys, $manga_id)
    {
        // array("Author 1", "authors 2"
        foreach($taxonomys as $taxonomy_name){
            Taxonomy::getDB()->where('name', $taxonomy_name);
            Taxonomy::getDB()->where('taxonomy', $taxonomy);
            $id = Taxonomy::getDB()->getValue('taxonomy','id');
            $slug = slugGenerator($taxonomy_name);
            $data = [
                'name' => $taxonomy_name,
                'slug' => $slug,
                'taxonomy' => $taxonomy
            ];

            if(empty($id)){
                $id = Taxonomy::getDB()->insert('taxonomy', $data);
            }
            $ids[] = $id;

            $data = (object)$data;
            $data->id = $id;

            $datas[] = $data;

        }

        if(!empty($datas)) {
            set_manga_data($taxonomy, $manga_id, $datas);
        }

        if(!empty($ids)){
            Taxonomy::AddMangaTaxonomy($manga_id, $ids);
        }
    }

    /**
     * Thêm tác giả vào manga
     * @param int $manga_id Id of manga
     * @param array $taxonomy_ids
     * @throws Exception
     */
    public static function AddMangaTaxonomy(int $manga_id, array $taxonomy_ids){
        foreach ($taxonomy_ids as $taxonomy_id){

            if(!Taxonomy::getDB()->where('manga_id', $manga_id)->where('taxonomy_id', $taxonomy_id)->getValue('taxonomy_manga', 'id')){
                Taxonomy::getDB()->insert('taxonomy_manga', [
                    "manga_id" => $manga_id, "taxonomy_id" => $taxonomy_id
                ]);
            }

        }

    }

    public static function GetListGenres($limit = null){
        $Cache = Cache::load();
        $CachedString = $Cache->getItem('list_genres1'. $limit);

        if (!$CachedString->isHit()) {
            Taxonomy::getDB()->where('taxonomy', 'genres');
            Taxonomy::getDB()->orderBy('name');

            $data = Taxonomy::getDB()->objectBuilder()->get('taxonomy', $limit, 'id, slug, name');

            $CachedString->set($data);
            $Cache->save($CachedString);

            return $data;
        }

        return $CachedString->get();
    }

    public static function ReSetTaoxaomyManga($manga_id){
        Model::getDB()->where('manga_id', $manga_id);
        Model::getDB()->delete('taxonomy_manga');
        $erro = Model::getDB()->getLastError();
        if($erro){
            exit($erro);
        }
    }
}