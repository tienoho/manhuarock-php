<?php if((new \Models\User)->hasPermission(['all', 'administrator'])): ?>

    <?php echo $__env->make('admin.components.manga_manage.administrator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
    <?php
        $page = input()->value('page', 1);
        $manga_model = Models\Model::getDB();
        $manga_model->pageLimit = 10;

        $manga_model->where('created_by', userget()->id);

        $mangas = $manga_model->objectBuilder()->paginate('mangas', $page);
        $total_page = $manga_model->totalPages;
    ?>

    <?php echo $__env->make('admin.components.manga_manage.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php endif; ?>


<?php /**PATH /www/wwwroot/v2.manhuarockz.com/resources/views/admin/pages/manga_manage.blade.php ENDPATH**/ ?>