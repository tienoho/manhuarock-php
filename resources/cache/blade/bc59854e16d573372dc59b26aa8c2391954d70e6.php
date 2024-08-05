
<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh Sách Báo Lỗi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('admin')); ?>">Admin</a></li>
                            <li class="breadcrumb-item active">Danh Sách Báo Lỗi</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mt-1"><i class="fas fa-list"></i> Danh sách báo lỗi</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">


                                    <?php if($reported): ?>
                                        <div class="col-12 alert alert-warning">Khi xoá báo lỗi, các trùng lặp sẽ bị xoá theo</div>
                                        <?php $__currentLoopData = $reported; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($report_item->type === 'chapter_error'): ?>
                                                <?php
                                                $data_report = json_decode($report_item->content)
                                                ?>

                                                <div class="col-12 border-bottom pt-2 pb-2">
                                                    <div class="text-bold text-info">
                                                        <?php echo e($data_report->report_title); ?>

                                                        <a href="<?php echo e(url('admin.chapter-edit', ['c_id' => $report_item->reported_id])); ?>"
                                                           class="ml-2 btn btn-xs btn-success">
                                                            <i class="fas fa-pen"></i></a>
                                                        <div class="btn btn-xs btn-danger delete-report"
                                                             data-id="<?php echo e($report_item->reported_id); ?>">
                                                            <i class="fas fa-trash"></i></div>
                                                    </div>


                                                    <div>
                                                        <span class="text-bold"> Nội dung lỗi: </span> <?php echo e($data_report->content); ?>

                                                    </div>
                                                </div>


                                            <?php endif; ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        Không có báo lỗi

                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card-footer clearfix bg-white">
                                <ul class="pagination m-0">
                                    <li class="page-item <?php echo e($page <= 1 ? 'disabled' : ''); ?>">
                                        <a class="page-link " href="<?php echo e(url(null, ['page' => $page - 1])); ?>">«</a>
                                    </li>
                                    <?php if($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php echo e(url(null, ['page' => $page - 1])); ?>"><?php echo e($page - 1); ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="page-item active">
                                        <a class="page-link" href="#"><?php echo e($page); ?></a>
                                    </li>
                                    <?php if($page + 1 <= $total_page): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php echo e(url(null, ['page' => $page + 1])); ?>"><?php echo e($page + 1); ?></a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if($page + 2 <= $total_page): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php echo e(url(null, ['page' => $page + 2 ])); ?>"><?php echo e($page + 2); ?></a>
                                        </li>
                                    <?php endif; ?>

                                    <li class="page-item <?php echo e($page >= $total_page ? 'disabled' : ''); ?>">
                                        <a class="page-link" href="<?php echo e(url(null, ['page' => $page + 1])); ?>">»</a>
                                    </li>

                                </ul>
                            </div>

                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/mangarock.top/resources/views/admin/pages/reported.blade.php ENDPATH**/ ?>