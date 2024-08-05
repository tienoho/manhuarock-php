<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="<?php echo e(userget()->avatar_url); ?>"
                 class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block"><?php echo e(userget()->name); ?></a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="<?php echo e(path_url('admin')); ?>" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <?php if((new \Models\User)->hasPermission(['all', 'manga'])): ?>
                <li class="nav-header">QUẢN LÍ TRUYỆN</li>
                <li class="nav-item">
                    <a href="<?php echo e(path_url('admin.manga-manage')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Tất Cả Truyện
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(path_url('admin.manga-add')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-plus-square"></i>
                        <p>
                            Thêm Truyện Mới
                        </p>
                    </a>
                </li>
            <?php endif; ?>

            <?php if((new \Models\User)->hasPermission(['all', 'administration'])): ?>
                <li class="nav-item">
                    <a href="<?php echo e(path_url('admin.pin-manga')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-map-pin"></i>
                        <p>
                            Ghim Truyện
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(path_url('admin.reported')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-bug"></i>
                        <p>
                            Báo Lỗi <span class="right badge badge-danger">
                                <?php
                                $reported = Models\Model::getDB()->getOne('reported', 'COUNT(id) as total');
                                ?>

                                <?php echo e($reported['total']); ?>

                            </span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(path_url('admin.scarper-manage')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-spider"></i>
                        <p>
                            Leech Truyện
                        </p>
                    </a>
                </li>
                <li class="nav-header">QUẢN LÍ BÌNH LUẬN</li>
                <li class="nav-item">
                    <a href="<?php echo e(path_url("admin.comment-manage")); ?>" class="nav-link">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            Tất Cả Bình Luận
                        </p>
                    </a>
                </li>

                <li class="nav-header">QUẢN LÝ THÀNH VIÊN</li>
                <li class="nav-item">
                    <a href="<?php echo e(path_url("admin.user-manage")); ?>" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Thành Viên
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(path_url("admin.group-manage")); ?>" class="nav-link">
                        <i class="nav-icon fas fa-globe-asia"></i>
                        <p>
                            Nhóm dịch
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(path_url("admin.request-manage")); ?>" class="nav-link">
                        <i class="nav-icon fas fa-globe-asia"></i>
                        <p>
                            Danh Sách Yêu Cầu
                        </p>
                    </a>
                </li>

                <li class="nav-header">QUẢN LÝ TAXONOMY</li>
                <li class="nav-item">
                    <a href="<?php echo e(path_url('admin.taxonomy-manage', ['type' => ''])); ?>" class="nav-link">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Tất cả Taxonomy
                        </p>
                    </a>
                </li>

                <li class="nav-header">QUẢN LÝ BÌNH LUẬN</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Tất Cả Bình Luận
                        </p>
                    </a>
                </li>

                <li class="nav-header">CÀI ĐẶT</li>
                <li class="nav-item">
                    <a href="<?php echo e(path_url("admin.settings")); ?>" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Cài Đặt Website
                        </p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="<?php echo e(path_url("admin.seo-setting")); ?>" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Cài đặt Seo
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(path_url("admin.ads-setting")); ?>" class="nav-link">
                        <i class="nav-icon fas fa-ad"></i>
                        <p>
                            Tuỳ Chỉnh ADS
                        </p>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/admin/components/sidebar.blade.php ENDPATH**/ ?>