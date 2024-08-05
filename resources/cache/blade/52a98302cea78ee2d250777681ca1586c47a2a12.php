
<?php $__env->startSection('title', L::_("Bookmark")); ?>

<?php $__env->startSection('content'); ?>
    <link href="/manga18fx/css/user.css" rel="stylesheet" type="text/css">
    <div class="manga-content">
        <div class="user-content">
            <div class="centernav">
                <div class="c-breadcrumb-wrapper">
                    <div class="c-breadcrumb">
                        <ol class="breadcrumb">
                            <li>
                                <a href="/" title="<?php echo e(L::_("Read Manga Online")); ?>">
                                    <?php echo e(L::_("Home")); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(url("user.reading-list")); ?>" class="active">
                                    <?php echo e(L::_("Bookmark")); ?>

                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="user-setting ng-scope" ng-controller="userFunction">
                    <div class="left">
                        <div class="bookmark-items">
                            <?php $__currentLoopData = $list_reading; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bookmark-item">
                                    <a rel="nofollow"
                                       href="<?php echo e(url("manga", ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                       title="<?php echo e($manga->name); ?>">
                                        <img class="img-loading" src="<?php echo e($manga->cover); ?>"
                                             data-src="<?php echo e($manga->cover); ?>" alt="<?php echo e($manga->name); ?>">
                                    </a>
                                    <div class="item-right">
                                        <p class="item-row-one">
                                            <a class="bookmark_remove" ng-click="removebookmark(<?php echo e($manga->id); ?>, 1)">
                                                <i class="icofont-close"></i><?php echo e(L::_("Remove")); ?></a>
                                            <a rel="nofollow" class="item-story-name text-nowrap color-red"
                                               href="<?php echo e(url("manga", ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"><?php echo e($manga->name); ?></a>
                                        </p>
                                        <span class="item-title text-nowrap wleft"><?php echo e(L::_("Current")); ?>:
                                        <?php $chapters = get_manga_data('chapters', $manga->id); ?>
                                            <?php if(!empty($chapters)): ?>
                                                <a class="a-h" style="color: #079eda;" rel="nofollow"
                                                   href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapters[0]->slug, 'c_id' => $chapters[0]->id])); ?>"><?php echo e($chapters[0]->name); ?></a></span>
                                        <?php else: ?>
                                            <span class="a-h" style="color: #079eda;"><?php echo e(L::_("No chapter yet")); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                    <?php echo $__env->make('themes.manga18fx.components.user.right', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-body'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.manga18fx.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/2ten.net/resources/views/themes/manga18fx/pages/reading-list.blade.php ENDPATH**/ ?>