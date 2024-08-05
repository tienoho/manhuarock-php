
<?php $__env->startSection('title', getConf('meta')['home_title']); ?>
<?php $__env->startSection('description', getConf('meta')['home_description']); ?>
<?php $__env->startSection('url', url('home')); ?>

<?php $__env->startSection('header-class', 'home-header'); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('themes.mangareader.components.home.deslide', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('themes.mangareader.components.home.text-share', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('themes.mangareader.components.home.trending', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


       <?php echo $__env->make('themes.mangareader.components.home.category', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div id="manga-continue"></div>
    <?php echo $__env->make('themes.mangareader.components.home.recommended', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('themes.mangareader.components.home.main-wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="ads-content">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-9778931209315986"
         data-ad-slot="6419846843"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-body'); ?>
    <script src="<?php echo e(asset('mangareader/js/swiper-bundle.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('mangareader/js/swiper-home.js')); ?>"></script>
    <link href="<?php echo e(asset('mangareader/css/swiper-home.css')); ?>" rel="stylesheet"/>

    <script>
        $(document).ready(function () {
            setTimeout(function () {
                // getScript('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-61310d692ddb96c6')
            }, 2000);
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.mangareader.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/pages/home.blade.php ENDPATH**/ ?>