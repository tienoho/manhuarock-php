<div id="main-wrapper">
    <div class="container">
        <div id="mw-2col">
            <!--Begin: main-content-->
            
            <?php echo $__env->make('themes.mangareader.components.home.main-content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--/End: main-content-->

            <!--Begin: main-sidebar-->
            <?php echo $__env->make('themes.mangareader.components.home.main-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!--/End: main-sidebar-->
            <div class="clearfix"></div>
            <?php echo $__env->make('themes.mangareader.components.home.completed', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/home/main-wrapper.blade.php ENDPATH**/ ?>