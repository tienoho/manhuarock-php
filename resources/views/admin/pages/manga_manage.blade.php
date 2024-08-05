@if((new \Models\User)->hasPermission(['all', 'administrator']))

    @include('admin.components.manga_manage.administrator')
@else
    <?php
        $page = input()->value('page', 1);
        $manga_model = Models\Model::getDB();
        $manga_model->pageLimit = 10;

        $manga_model->where('created_by', userget()->id);

        $mangas = $manga_model->objectBuilder()->paginate('mangas', $page);
        $total_page = $manga_model->totalPages;
    ?>

    @include('admin.components.manga_manage.user')

@endif


