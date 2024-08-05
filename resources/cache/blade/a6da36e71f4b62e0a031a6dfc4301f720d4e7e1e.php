<?php if(!is_login()): ?>
    <div id="user-slot">
        <div class="header_right-user user-logged">
            <a class="btn-user btn btn-login" data-target="#modal-auth" data-toggle="modal"><i
                        class="fas fa-user-circle mr-2"></i><?php echo e(L::_('Member')); ?></a>
        </div>
    </div>
<?php else: ?>
    <div class="hr-notifications">
        <div aria-expanded="false" aria-haspopup="true" class="hrn-icon" data-toggle="dropdown">
            <i class="fas fa-bell"></i>
        </div>
    </div>
    <div id="user-slot">
        <div class="header_right-user logged">
            <div class="dropdown">
                <div aria-expanded="false" class="btn-avatar" data-toggle="dropdown">
                    <img alt="<?php echo e(userget()->name); ?>" src="<?php echo e(userget()->avatar_url); ?>"></div>
                <div class="dropdown-menu dropdown-menu-model" id="user_menu">
                    <a class="dropdown-item" href="<?php echo e(url('user.profile')); ?>">
                        <i class="fas fa-user mr-2"></i><?php echo e(L::_('Profile')); ?>

                    </a>
                    <a class="dropdown-item" href="/user/continue-reading">
                        <i class="fas fa-glasses mr-2"></i><?php echo e(L::_('Continue Reading')); ?>

                    </a>
                    <a class="dropdown-item" href="<?php echo e(url('user.reading-list')); ?>">
                        <i class="fas fa-bookmark mr-2"></i><?php echo e(L::_('Reading List')); ?>

                    </a>
                    <a onclick="alert('Chức năng này đang được xây dựng')" class="dropdown-item" href="#">
                        <i class="fas fa-bell mr-2"></i><?php echo e(L::_('Notifications')); ?>

                    </a>
                    <a class="dropdown-item" href="<?php echo e(url('user.request-permission')); ?>">
                        <i class="fas fa-file-import mr-2"></i>Up Truyện
                    </a>
                    <a class="dropdown-item di-bottom" href="/logout">Logout<i class="fas fa-arrow-right ml-2 mr-1"></i></a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="clearfix"></div>
<?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/components/ajax/login-state.blade.php ENDPATH**/ ?>