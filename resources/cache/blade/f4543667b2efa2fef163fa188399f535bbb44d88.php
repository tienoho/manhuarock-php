
<?php $__env->startSection('title', L::_('Continue Reading')); ?>

<?php $__env->startSection('content'); ?>
    <div id="main-wrapper">
        <div class="container">
            <div id="mw-2col">
                <!--Begin: main-content-->
                    <?php echo $__env->make('themes.mangareader.components.user.continue-reading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!--/End: main-content-->

                <!--Begin: main-sidebar-->
                    <?php echo $__env->make('themes.mangareader.components.user.main-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!--/End: main-sidebar-->
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-body'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.mangareader.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/pages/continue-reading.blade.php ENDPATH**/ ?>