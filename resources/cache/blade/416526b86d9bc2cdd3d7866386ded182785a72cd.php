<?php if(!is_login()): ?>
    <div class="user-block tright" ng-controller="userFunction">
        <div class="guest-option">
            <a href="<?php echo e(path_url("user.login")); ?>"><?php echo e(L::_("Sign In")); ?></a>
            <a href="<?php echo e(path_url("user.register")); ?>"><?php echo e(L::_("Sign Up")); ?></a>
        </div>
    </div>
<?php else: ?>
    <div class="user-block tright ng-scope" ng-controller="userFunction">
        <div class="box-user-options">


            <div class="c-user_avatar">
                <a href="<?php echo e(path_url("user.reading-list")); ?>">
                    <div class="c-user_avatar-image">
                        <img alt="" src="<?php echo e(userget()->avatar_url); ?>" class="avatar" height="50" width="50"
                             style="margin-top: -5px;">
                    </div>

                    <div class="displayname tleft">
                        <span class="name tleft">Hi, <?php echo e(userget()->name); ?></span>
                    </div>
                </a>
            </div>
            <div class="user-logout">


                <a href="<?php echo e(path_url("logout")); ?>" data-method="get">
                    <i class="icofont-ui-power"></i>
                </a>
            </div>
        </div>
    </div>

<?php endif; ?><?php /**PATH /www/wwwroot/mangarock.top/resources/views/themes/manga18fx/components/user-block.blade.php ENDPATH**/ ?>