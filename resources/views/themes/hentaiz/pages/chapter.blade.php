@extends('themes.hentaiz.layouts.full')

<?php
    if(!isset($chapter)){
        $model = \Models\Model::getDB();
        $model->where('manga_id', $manga->id);
        $model->orderBy('chapter_index', 'ASC');

        $chapter = $model->getOne('chapters');
    }
?>

@section("content")
    <div class="container-fluid py-3">


    </div>
@stop
