<div id="main-content">
    <!--Begin: Section Manga list-->
    <section class="block_area block_area_profile">
        <div class="block_area-header">
            <div class="bah-heading">
                <h2 class="cat-heading"><?php echo e(L::_('Profile Manager')); ?></h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="block_area-content">
            <form class="preform preform-center" method="post" id="profile-form">
                <div class="profile-avatar">
                    <img data-toggle="modal" data-target="#modalavatars" id="preview-avatar" src="<?php echo e(userget()->avatar_url); ?>" alt="<?php echo e(userget()->name); ?>">
                    <div data-toggle="modal" data-target="#modalavatars" class="pa-edit"><?php echo e(L::_('Change Avatar')); ?>

                    </div>
                </div>
                <div class="form-group">
                    <label class="prelabel" for="pro5-email">Email address</label>
                    <input type="email" class="form-control" disabled="" id="pro5-email" value="<?php echo e(userget()->email); ?>">
                </div>
                <div class="form-group">
                    <label class="prelabel" for="pro5-name">Display name</label>
                    <input type="text" class="form-control" id="pro5-name" required="" name="name" value="<?php echo e(userget()->name); ?>">
                </div>
                <div class="block">
                    <a class="btn btn-xs btn-blank" data-toggle="collapse" href="#show-changepass"><i class="fas fa-key mr-2"></i>Change password</a>
                </div>
                <div id="show-changepass" class="collapse mt-3">
                    <div class="form-group">
                        <label class="prelabel" for="pro5-currentpass">Current Password</label>
                        <input type="password" class="form-control" id="pro5-currentpass" name="current_password">
                    </div>
                    <div class="form-group">
                        <label class="prelabel" for="pro5-pass">New Password</label>
                        <input type="password" class="form-control" id="pro5-pass" name="new_password">
                    </div>
                    <div class="form-group">
                        <label class="prelabel" for="pro5-confirm">Confirm New Password</label>
                        <input type="password" class="form-control" id="pro5-confirm" name="confirm_new_password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="mt-4">&nbsp;</div>
                    <button class="btn btn-block btn-primary">Save</button>
                    <div class="loading-relative" id="profile-loading" style="display:none">
                        <div class="loading">
                            <div class="span1"></div>
                            <div class="span2"></div>
                            <div class="span3"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--End: Section Manga list-->
    <div class="clearfix"></div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/user/profile.blade.php ENDPATH**/ ?>