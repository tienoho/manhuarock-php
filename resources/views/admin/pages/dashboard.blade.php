@extends('admin.layout')

@section('css_plugins')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
          integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@stop

@section('javascript_plugins')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function () {
            $('.select2').select2()
        });
    </script>
@stop

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        @if((new \Models\User)->hasPermission(['all', 'administrator']))
            <?php
            $manga = \Models\Model::getDB()->objectBuilder()->getOne('mangas', 'COUNT(id) as total');
            $user = \Models\Model::getDB()->objectBuilder()->getOne('user', 'COUNT(id) as total');
            $visitor = \Models\Model::getDB()->objectBuilder()->getOne('mangas', 'SUM(views) as total');
            ?>
            @include('admin.components.dashboard.administrator')
        @else
            <?php
            $manga = \Models\Model::getDB()->objectBuilder()->where('created_by', userget()->id)->getOne('mangas', 'COUNT(id) as total');

            \Models\Model::getDB()->join('taxonomy', 'taxonomy.id=taxonomy_user.taxonomy_id');
            \Models\Model::getDB()->joinWhere('taxonomy.id=taxonomy_user.taxonomy_id', 'taxonomy.taxonomy', 'artists');
            $group = \Models\Model::getDB()->objectBuilder()->where('taxonomy_user.user_id', userget()->id)->getOne('taxonomy_user', 'COUNT(taxonomy_user.taxonomy_id) as total');

            \Models\Model::getDB()->where('chapters.created_by', userget()->id);
            $chapters = \Models\Model::getDB()->objectBuilder()->getOne('chapters', 'SUM(chapters.views) as totalview, SUM(chapters.earned) as totalearned');

            $received = \Models\Model::getDB()->where('id', userget()->id)->getValue('user','received');
            $administration_conf = getConf('administration');
            ?>
            @include('admin.components.dashboard.user')
        @endif
    </div>
@stop