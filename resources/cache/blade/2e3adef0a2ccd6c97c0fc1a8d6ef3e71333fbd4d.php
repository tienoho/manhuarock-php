<div class="right">
    <div class="setting-choose">
        <ul>
            <?php if((new \Models\User)->hasPermission(['all', 'manga'])): ?>
                <li>
                    <a href="<?php echo e(path_url('admin')); ?>"><?php echo e(L::_("Admin")); ?></a>
                </li>
            <?php endif; ?>
            <li>
                <a href="<?php echo e(path_url('user.profile')); ?>"><?php echo e(L::_("Profile")); ?></a>
            </li>
            <li>
                <a href="<?php echo e(path_url("user.reading-list")); ?>"><?php echo e(L::_("Bookmarks")); ?></a>
            </li>
        </ul>
    </div>
    <div class="sidebar">
        <?php echo $__env->make("themes.manga18fx.components.popular-sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div><?php /**PATH /www/wwwroot/2ten.net/resources/views/themes/manga18fx/components/user/right.blade.php ENDPATH**/ ?>