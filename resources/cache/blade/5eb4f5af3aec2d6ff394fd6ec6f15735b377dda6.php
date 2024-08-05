

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid"></div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Quản lí bình luận</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <?php if($comments): ?>
                                <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-12 border-bottom pt-2 pb-2 comment-item" mnbv
                                         data-id="<?php echo e($comment->id); ?>">
                                        <div class="text-bold text-info mw-100"
                                             style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo e($comment->username); ?>

                                            - <span class="font-weight-normal text-gray"><?php echo e($comment->name); ?></span>
                                        </div>

                                        <div class="btn btn btn-danger delete-comment float-right">
                                            <i class="fas fa-trash"></i></div>


                                        <div>
                                            <span class="text-bold"> Nội dung: </span> <?php echo e($comment->content); ?>

                                        </div>
                                    </div>


                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="col-12">Không có dữ liệu</div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="card-footer clearfix bg-white">
                        <ul class="pagination m-0">
                            <li class="page-item <?php echo e($page <= 1 ? 'disabled' : ''); ?>">
                                <a class="page-link "
                                   href="<?php echo e(url(null, null, [ 'page' => $page - 1])); ?>">«</a>
                            </li>
                            <?php if($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="<?php echo e(url(null, null, [ 'page' => $page - 1])); ?>"><?php echo e($page - 1); ?></a>
                                </li>
                            <?php endif; ?>
                            <li class="page-item active">
                                <a class="page-link" href="#"><?php echo e($page); ?></a>
                            </li>
                            <?php if($page + 1 <= $total_page): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="<?php echo e(url(null, null, [ 'page' => $page + 1])); ?>"><?php echo e($page + 1); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if($page + 2 <= $total_page): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="<?php echo e(url(null, null, [ 'page' => $page + 2 ])); ?>"><?php echo e($page + 2); ?></a>
                                </li>
                            <?php endif; ?>

                            <li class="page-item <?php echo e($page >= $total_page ? 'disabled' : ''); ?>">
                                <a class="page-link"
                                   href="<?php echo e(url(null, null, [ 'page' => $page + 1])); ?>">»</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </section>

    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/2ten.net/resources/views/admin/pages/comment-manage.blade.php ENDPATH**/ ?>