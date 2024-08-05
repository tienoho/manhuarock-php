

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid"></div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">

                    <?php if(!$type): ?>
                        <div class="card-header">
                            <h2 class="card-title">Quản lí Taxonomy</h2>
                        </div>

                        <div class="card-body">
                            <?php echo $__env->make('admin.components.taxonomy.all', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php else: ?>
                        <div class="card-header">
                            <h3 class="card-title">Quản lí Taxonomy: <?php echo e($type); ?></h3>
                            <div class="card-tools">
                                <a id="add-taxonomy" data-taxonomy="<?php echo e($type); ?>" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Thêm</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php echo $__env->make('admin.components.taxonomy.detail-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="card-footer clearfix bg-white">
                            <ul class="pagination m-0">
                                <li class="page-item <?php echo e($page <= 1 ? 'disabled' : ''); ?>">
                                    <a class="page-link " href="<?php echo e(url(null, null, ['s' => $search, 'page' => $page - 1])); ?>">«</a>
                                </li>
                                <?php if($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo e(url(null, null, ['s' => $search, 'page' => $page - 1])); ?>"><?php echo e($page - 1); ?></a>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item active">
                                    <a class="page-link" href="#"><?php echo e($page); ?></a>
                                </li>
                                <?php if($page + 1 <= $total_page): ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo e(url(null, null, ['s' => $search, 'page' => $page + 1])); ?>"><?php echo e($page + 1); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if($page + 2 <= $total_page): ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo e(url(null, null, ['s' => $search, 'page' => $page + 2 ])); ?>"><?php echo e($page + 2); ?></a>
                                    </li>
                                <?php endif; ?>

                                <li class="page-item <?php echo e($page >= $total_page ? 'disabled' : ''); ?>">
                                    <a class="page-link" href="<?php echo e(url(null, null, ['s' => $search, 'page' => $page + 1])); ?>">»</a>
                                </li>

                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </section>

    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/admin/pages/taxonomy-manage.blade.php ENDPATH**/ ?>