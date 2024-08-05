

<?php $__env->startSection('content'); ?>
    <div class="fed-part-case" id="main-content">
        <div class="wrap-content-part list-manga">
            <div class="header-content-part">
                <div class="title"><?php echo e(L::_("Bookmarks")); ?></div>
            </div>
            <div class="body-content-part">
                <div class="row cuutruyen">
                    <?php $__currentLoopData = $list_reading; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make("themes.kome.template.thumb-item-flow", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <li class="list-pager">
                    <ul class="pager">

                        <?php if($paginate->current_page <= 1): ?>
                            <li class="prev disabled"><a href="#">«</a></li>
                        <?php else: ?>
                            <li class="prev">
                                <a href="<?php echo e(url(null, ['page' => $paginate->current_page - 1], $params)); ?>"
                                   data-page="<?php echo e($paginate->current_page - 1); ?>">«</a>
                            </li>
                        <?php endif; ?>

                        <?php if($paginate->current_page - 1 <= 0): ?>
                            <li class="active">
                                <a href="<?php echo e(url()); ?>"
                                   data-page="<?php echo e($paginate->current_page); ?>"><?php echo e($paginate->current_page); ?></a>
                            </li>
                        <?php else: ?>
                            <li class="">
                                <a href="<?php echo e(url(null, ['page' => $paginate->current_page - 1], $params)); ?>"
                                   data-page="<?php echo e($paginate->current_page - 1); ?>"><?php echo e($paginate->current_page - 1); ?></a>
                            </li>
                            <li class="active">
                                <a href="<?php echo e(url(null, ['page' => $paginate->current_page], $params)); ?>"
                                   data-page="<?php echo e($paginate->current_page); ?>"><?php echo e($paginate->current_page); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php
                        $next_pages = [1, 2, 3];
                        ?>
                        <?php $__currentLoopData = $next_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pagenext): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($paginate->current_page + $pagenext <=$paginate->total_page): ?>
                                <li>
                                    <a href="<?php echo e(url(null, ['page' => $paginate->current_page + $pagenext], $params)); ?>"
                                       data-page="<?php echo e($paginate->current_page + $pagenext); ?>"><?php echo e($paginate->current_page + $pagenext); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php if($paginate->current_page < $paginate->total_page): ?>
                            <li class="next">
                                <a href="<?php echo e(url(null, ['page' => $paginate->current_page + 1], $params)); ?>"
                                   data-page="<?php echo e($paginate->current_page + 1); ?>">»</a>
                            </li>
                        <?php else: ?>
                            <li class="next disabled">
                                <a href="#">»</a>
                            </li>
                        <?php endif; ?>


                    </ul>
                </li>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.kome.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/kome/pages/reading-list.blade.php ENDPATH**/ ?>