<div id="main-sidebar">
    <section class="block_area block_area_sidebar block_area-profile">
        <div class="block_area-header">
            <div class="float-left bah-heading">
                <h2 class="cat-heading">Profile Menu</h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="block_area-content">
            <div class="menu-profiles">
                <ul class="ulclear">
                    <li class="<?php echo e(request()->getLoadedRoute()->getName() === 'user.profile' ? 'active' : ''); ?>">
                        <a href="<?php echo e(path_url('user.profile')); ?>" class="mp-item"><i class="fas fa-user mr-3"></i><?php echo e(L::_('Profile')); ?></a>
                    </li>
                    <li
                        class="<?php echo e(request()->getLoadedRoute()->getName() === 'user.continue-reading' ? 'active' : ''); ?>">
                        <a href="<?php echo e(path_url('user.continue-reading')); ?>" class="mp-item"><i
                                class="fas fa-glasses mr-3"></i><?php echo e(L::_('Continue Reading')); ?></a>
                    </li>
                    <li class="<?php echo e(request()->getLoadedRoute()->getName() === 'user.reading-list' ? 'active' : ''); ?>">
                        <a href="<?php echo e(path_url('user.reading-list')); ?>" class="mp-item"><i
                                class="fas fa-bookmark mr-3"></i><?php echo e(L::_('Reading List')); ?></a>
                    </li>
                    <?php 
                    $active = "";
                    if(strpos(url(), '/user/payment') !== false) {
                        $active = "active";
                    }	

                    ?>
                    <li class="<?php echo e($active); ?>">
                        <a href="/user/payment" class="mp-item">
                            <i class="fas fa-coins mr-3"></i></i><?php echo e(L::_('Nạp Token')); ?></a>
                    </li>

                    <li class="">
                        <a href="#" class="mp-item"><i class="fas fa-bell mr-3"></i><?php echo e(L::_('Notifications')); ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/user/main-sidebar.blade.php ENDPATH**/ ?>