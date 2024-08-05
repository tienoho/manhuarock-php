<div id="main-sidebar">
    <!--sidebar block-->
    <?php echo $__env->make('themes.mangareader.components.category-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--/sidebar block-->

    <!--sidebar block-->
    <?php echo $__env->make('themes.mangareader.components.manga.related', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--/sidebar block-->
</div><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/components/manga/main-sidebar.blade.php ENDPATH**/ ?>