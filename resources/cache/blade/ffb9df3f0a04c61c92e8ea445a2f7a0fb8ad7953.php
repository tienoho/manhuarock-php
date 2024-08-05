

<?php
include(ROOT_PATH . '/resources/views/includes/manga.php');
?>

<?php $__env->startSection('title', $metaConf['manga_title']); ?>
<?php $__env->startSection('description', $metaConf['manga_description'] ); ?>
<?php $__env->startSection('url', $manga_url); ?>
<?php $__env->startSection('image', $manga->cover); ?>

<?php $__env->startSection('data-id', $manga->id); ?>

<?php $__env->startSection('schema'); ?>
    <script type="application/ld+json">
        <?php echo manga_schema($manga); ?>

    </script>

    <script type="application/ld+json">
        <?php echo chaps_schema($manga, $chapters); ?>

    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!--Begin: Detail-->
    <?php echo $__env->make('themes.mangareader.components.manga.detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--/End: Detail-->
    <!--Begin: Main-->
    <div id="main-wrapper" class="page-layout page-detail">
        <div class="container">
            <div id="mw-2col">
                <!--Begin: main-content-->
            <?php echo $__env->make('themes.mangareader.components.manga.main-content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--/End: main-content-->
                <!--Begin: main-sidebar-->
            <?php echo $__env->make('themes.mangareader.components.manga.main-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--/End: main-sidebar-->
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('themes.mangareader.components.manga.modal-description', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js-body'); ?>
    <script type="text/javascript">

        $(document).ready(function () {
            setTimeout(function () {
                getScript('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-61310d692ddb96c6');
                getScript('https://cdn.jsdelivr.net/npm/jquery.scrollto@2.1.3/jquery.scrollTo.min.js');

                readingListInfo('detail');
            }, 1000);

            $(".detail-toggle").click(function (e) {
                $(this).toggleClass("active");
                $(".anis-content").toggleClass("active");
            });
            if ($('.lang-item[data-code=en]').length > 0) {
                $('.lang-item[data-code=en]').click();
            } else {
                $('.c-select-lang').first().click();
                $('.v-select-lang').first().click();
            }

        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.mangareader.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/pages/manga.blade.php ENDPATH**/ ?>