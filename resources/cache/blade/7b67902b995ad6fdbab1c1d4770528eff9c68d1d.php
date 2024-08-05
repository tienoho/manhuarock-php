
<?php $__env->startSection('title', getConf('meta')['home_title']); ?>
<?php $__env->startSection('description', getConf('meta')['home_description']); ?>
<?php $__env->startSection('url', url('home')); ?>

<?php echo $__env->make('ads.banner-ngang', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('ads.banner-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection("ping-list"); ?>
    <div class="wrap-content-part">
        <div class="header-content-part pl-sm-3 pr-sm-3 pl-md-3 pr-md-3 pl-lg-2 pr-lg-2">
            <h2 class="title">
                <span class="ico-flame-sharp icon-2x icon-title"></span><?php echo e(L::_("Trending")); ?>

            </h2>
            <a class="more" href="<?php echo e(url('manga_list')); ?>"> <?php echo e(L::_("View more")); ?> »</a>
        </div>
        <div class="body-content-part">
            <div class="row">
                <?php $__currentLoopData = (new Models\Manga())->pin_manga(getConf('site')['total_pin']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make("themes.kome.template.thumb-item-flow", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("newupdate-list"); ?>
    <div class="wrap-content-part">
        <div class="header-content-part pl-sm-3 pr-sm-3 pl-md-3 pr-md-3 pl-lg-2 pr-lg-2">
            <h2 class="title"><?php echo e(L::_("New Update")); ?></h2>
            <a class="more" href="<?php echo e(url('manga_list')); ?>"> <?php echo e(L::_("View more")); ?> »</a></div>
        <div class="body-content-part">
            <div class="row">
                <?php $__currentLoopData = (new Models\Manga())->new_update($page, getConf('site')['newupdate_home']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make("themes.kome.template.thumb-item-flow", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="list-pager">
                <div class="pager">
                    <a href="<?php echo e(url('manga_list')); ?>"
                       class="centertextblock1 btn-top11 btn-primary btn_theodoitruyen shadow-none"><?php echo e(L::_("View more")); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="fed-part-case" id="main-content">
        <?php echo $__env->yieldContent("ping-list"); ?>

        <?php echo $__env->yieldContent("newupdate-list"); ?>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-body'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.kome.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/themes/kome/pages/home.blade.php ENDPATH**/ ?>