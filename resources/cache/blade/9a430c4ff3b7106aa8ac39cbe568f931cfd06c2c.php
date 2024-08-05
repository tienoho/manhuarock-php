

<?php $__env->startSection('title', "Nội Dung Này Không Còn Tồn Tại Trên Hoimetruyen.com"); ?>

<?php $__env->startSection('content'); ?>
    <div id="main-wrapper" class="page-layout page-404">
        <div class="container">
            <div class="container-404 text-center">
                <div class="c4-big-img"><img src="/mangareader/images/404.png"></div>
                <div class="c4-medium"><?php echo e(L::_("Oops, sorry we can't find that page!")); ?></div>
                <div class="c4-small"><?php echo e(L::_("Either something went wrong or the page doesn't exist anymore.")); ?></div>
                <div class="c4-button">
                    <a href="<?php echo e(url("home")); ?>" class="btn btn-radius btn-focus"><i class="fa fa-chevron-circle-left mr-2"></i><?php echo e(L::_("Back to homepage")); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.mangareader.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/pages/404.blade.php ENDPATH**/ ?>