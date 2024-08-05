

<?php
include(ROOT_PATH . '/resources/views/includes/chapter.php');
?>


<?php $__env->startSection('title', $metaConf['chapter_title']); ?>
<?php $__env->startSection('description', $metaConf['chapter_description']); ?>

<?php $__env->startSection('url', $chapter_url); ?>
<?php $__env->startSection('image', $manga->cover); ?>

<?php $__env->startSection('data-id', $manga->id); ?>

<?php $__env->startSection('content'); ?>
    <div id="wrapper" data-reading-id="<?php echo e($chapter->id); ?>" data-reading-by="chap" data-lang-code="en" data-manga-id="<?php echo e($manga->id); ?>">
        <!--Begin: Header-->
    <?php echo $__env->make('themes.mangareader.components.chapter.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--End: Header-->
        <div class="clearfix"></div>
        <div class="mr-tools mrt-top">
            <div class="container">
                <div class="read_tool">
                    <div class="float-left">
                        <div class="rt-item">
                            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    class="btn"><?php echo e(L::_('Reading Mode')); ?>: <span id="current-mode">- <?php echo e(L::_('Select')); ?> -</span> <i
                                        class="fas fa-angle-down ml-2"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-model" aria-labelledby="ssc-list">
                                <a class="dropdown-item mode-item" data-value="vertical" href="javascript:;"><?php echo e(L::_('Vertical')); ?></a>
                                <a class="dropdown-item mode-item" data-value="horizontal" href="javascript:;"><?php echo e(L::_('Horizontal')); ?></a>
                            </div>
                        </div>
                        <div class="rt-item">
                            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    class="btn"><?php echo e(L::_('Reading Direction')); ?>: <span id="current-direction"></span> <i
                                        class="fas fa-angle-down ml-2"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-model" aria-labelledby="ssc-list">
                                <a class="dropdown-item direction-item" data-value="rtl" href="javascript:;">RTL</a>
                                <a class="dropdown-item direction-item" data-value="ltr" href="javascript:;">LTR</a>
                            </div>
                        </div>
                        <div class="rt-item">
                            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    class="btn"><?php echo e(L::_('Quality')); ?>: <span id="current-quality"></span> <i
                                        class="fas fa-angle-down ml-2"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-model" aria-labelledby="ssc-list">
                                <a class="dropdown-item quality-item" data-value="high"><?php echo e(L::_('High')); ?></a>
                                <a class="dropdown-item quality-item" data-value="medium"><?php echo e(L::_('Medium')); ?></a>
                                <a class="dropdown-item quality-item" data-value="low"><?php echo e(L::_('Low')); ?></a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="float-right">
                        <div class="rt-item" id="rt-close">
                            <button type="button" class="btn"><i class="fas fa-times mr-2"></i><?php echo e(L::_('Close')); ?></button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div id="images-content">
            <div id="first-read" style="display: none;">
                <div class="read-tips">
                    <div class="read-tips-layout">
                        <h2 style=" color: #451184; font-size: 14px; font-style: italic; font-family: monospace; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; "><?php echo e($manga->name); ?> <?php echo e($chapter->name); ?></h2>

                        <div class="rtl-head"><?php echo e(L::_('Setting for the first time...')); ?></div>
                        <div class="description"><?php echo e(L::_('Select the reading mode you want. You can re-config in')); ?> <strong
                                    class="ml-2"><i class="fas fa-cog mr-2"></i><?php echo e(L::_('Settings')); ?> > <?php echo e(L::_('Reading Mode')); ?></strong>
                        </div>
                        <div class="rtl-rows">
                            <a href="javascript:();" class="rtl-row mode-item" data-value="vertical">
                                <div class="rtl-btn rtl-ver">
                                    <div class="rtl-container">
                                        <span></span><span></span><span></span><span></span><span></span><span></span>
                                    </div>
                                </div>
                                <div class="label-row"><?php echo e(L::_('Vertical Follow')); ?></div>
                                <div class="checked"><i class="fas fa-check-circle"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <a href="javascript:;" class="rtl-row mode-item" data-value="horizontal">
                                <div class="rtl-btn rtl-hoz">
                                    <div class="rtl-container">
                                        <span></span><span></span><span></span><span></span><span></span><span></span>
                                    </div>
                                </div>
                                <div class="label-row"><?php echo e(L::_('Horizontal Follow')); ?></div>
                                <div class="checked"><i class="fas fa-check-circle"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div id="main-wrapper" class="page-layout page-read mb-0">
                    <div class="page-read-setting">
                        <div class="anis-cover"
                             style="background-image: url(<?php echo e($manga->cover ?? "/mangareader/images/share.png"); ?>)"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div id="read-comment">
            <div class="rc-close"><span aria-hidden="true">×</span></div>
            <div class="comments-wrap">
                <div class="sc-header">
                    <div class="sc-h-title"><?php echo e((new \Models\Manga)->count_comment($manga->id)); ?> Comments</div>
                    <div class="sc-h-sort">
                        <a class="btn btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    class="fas fa-angle-down mr-2"></i>Sort by</a>
                        <div class="dropdown-menu dropdown-menu-model dropdown-menu-normal" aria-labelledby="ssc-list">
                            <a class="dropdown-item cm-sort" data-value="top" href="javascript:;">Top<i
                                        class="fas fa-check ml-2" style="display: none;"></i></a>
                            <a class="dropdown-item cm-sort active" data-value="newest" href="javascript:;">Newest<i
                                        class="fas fa-check ml-2"></i></a>
                            <a class="dropdown-item cm-sort" data-value="oldest" href="javascript:;">Oldest<i
                                        class="fas fa-check ml-2" style="display: none;"></i></a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="content-comments"></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.mangareader.layouts.read', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/pages/chapter.blade.php ENDPATH**/ ?>