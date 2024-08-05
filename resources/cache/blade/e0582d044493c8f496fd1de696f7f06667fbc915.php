<section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo e($manga->total); ?></h3>

                                <p>Tổng số truyện</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="<?php echo e(url("admin.manga-manage")); ?>" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <?php if($user->total  < 0 || $visitor->total < 0): ?>
                                    <h3><?php echo e(round(($user->total / $visitor->total) * 100, 2)); ?><sup
                                                style="font-size: 20px">%</sup></h3>
                                <?php else: ?>
                                    <h3>0<sup style="font-size: 20px">%</sup></h3>
                                <?php endif; ?>
                                <p>Tỉ lệ đăng kí</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="<?php echo e(url('admin.user-manage')); ?>" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo e($user->total); ?></h3>

                                <p>Thành viên đã đăng kí</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="<?php echo e(url('admin.user-manage')); ?>" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?php echo e($visitor->total); ?></h3>

                                <p>Khách truy cập</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
        </div>

        <form class="mt-3" action="<?php echo e(url()); ?>">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Loại truyện:</label>
                                <select class="select2" multiple="multiple" data-placeholder="Tất cả"
                                        style="width: 100%;">
                                    <?php $__currentLoopData = allComicType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($slug); ?>"><?php echo e($type); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>;
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Xếp theo:</label>
                                <select class="select2" style="width: 100%;">
                                    <option selected>ASC</option>
                                    <option>DESC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Xếp bởi:</label>
                                <select class="select2" style="width: 100%;">
                                    <option selected>Tên</option>
                                    <option>Ngày Cập Nhật</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <input type="search" class="form-control form-control-lg"
                                   placeholder="Nhập tên truyện ở đây" value="">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/admin/components/dashboard/administrator.blade.php ENDPATH**/ ?>