

<?php $__env->startSection('title', "Nội Dung Này Không Còn Tồn Tại!"); ?>

<?php $__env->startSection('content'); ?>
    <?php response()->httpCode(301)->redirect('/'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.manga18fx.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/manhuarockz.com/resources/views/themes/manga18fx/pages/404.blade.php ENDPATH**/ ?>