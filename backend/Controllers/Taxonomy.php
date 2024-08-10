<?php

namespace Controllers;

use Models\Model;
use Services\Blade;

class Taxonomy
{
    function manage($type = null)
    {
        $page = input()->value('page', 1);
        $search = input()->value('s');

        Model::getDB()->orderBy('created_at');

        if (!($type)) {
            $taxonomys = Model::getDB()->objectBuilder()
                ->groupBy('taxonomy')
                ->get('taxonomy', null, 'taxonomy');
        } else {

            if ($search) {
                Model::getDB()->where('name', "%$search%", 'LIKE');
            }

            Model::getDB()->pageLimit = 20;
            $taxonomys = Model::getDB()->objectBuilder()
                ->where('taxonomy', $type)->paginate('taxonomy', $page);
        }

        $total_page = Model::getDB()->totalPages;

        return (new Blade())->render('admin.pages.taxonomy-manage', [
            'type' => $type,
            'taxonomys' => $taxonomys,
            'page' => $page,
            'total_page' => $total_page,
            'search' => $search
        ]);

    }


    function addTaxonomyTemplate($type){
        return (new Blade())->render('admin.template.add-taxonomy', [
            'type' => $type
        ]);
    }

    function addTaxonomy($type)
    {
        if (!$type) {
            response()->httpCode(404)->redirect('/');
        }

        $input = [
            'taxonomy' => $type,
            'name' => input()->value('name'),
            'slug' => slugGenerator(input()->value('name')),
            'description' => input()->value('description'),
        ];

        Model::getDB()->insert('taxonomy', $input);

        echo Model::getDB()->getLastError();
        response()->json([
            'status' => true
        ]);
    }

    function editTaxonomyTemplate($id){
        $taxonomy = Model::getDB()->where('id', $id)
            ->objectBuilder()
            ->getOne('taxonomy');

        return (new Blade())->render('admin.template.edit-taxonomy', [
            'taxonomy' => $taxonomy
        ]);
    }
}