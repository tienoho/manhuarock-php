
<?php $__env->startSection('title', L::_("Profile")); ?>

<?php $__env->startSection('content'); ?>
    <link href="/manga18fx/css/user.css" rel="stylesheet" type="text/css">

    <div class="manga-content wleft">
        <div class="user-content">
            <div class="centernav">
                <div class="c-breadcrumb-wrapper">
                    <div class="c-breadcrumb">
                        <ol class="breadcrumb">
                            <li>
                                <a href="/" title="<?php echo e(L::_("Home")); ?>">
                                    <?php echo e(L::_("Home")); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(url()); ?>" class="active">
                                    <?php echo e(L::_("Profile")); ?>

                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="user-setting wleft">
                    <div class="left">
                        <div class="user-settings wleft ng-scope" ng-controller="userSetting">
                            <div class="tab-item wleft">
                                <div class="settings-title">
                                    <h3>
                                        <?php echo e(L::_("Change Your Display Name")); ?>

                                    </h3>
                                </div>
                                <div class="form-items wleft">
                                    <label class="form-label"><?php echo e(L::_("Current Display Name")); ?></label>
                                    <div class="form-input">
                                        <!-- ngIf: !validate --><span class="show ng-scope"
                                                                      ng-if="!validate"><?php echo e(userget()->name); ?></span>
                                        <!-- end ngIf: !validate -->
                                        <!-- ngIf: validate -->
                                    </div>
                                </div>
                                <form ng-submit="changeDisplay(form)" class="ng-pristine ng-valid">
                                    <div class="form-items wleft">
                                        <label class="form-label"><?php echo e(L::_("New Display name")); ?></label>
                                        <div class="form-input">
                                            <input type="text" placeholder="Display Name" ng-model="form.displayname"
                                                   class="ng-pristine ng-untouched ng-valid ng-empty">
                                            <div class="message wleft">
                                                <!-- ngIf: validate -->
                                                <!-- ngIf: !validate --><p ng-if="!validate"
                                                                           class="error ng-binding ng-scope"></p>
                                                <!-- end ngIf: !validate -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-items wleft">
                                        <label class="form-label"><?php echo e(L::_("Submit")); ?></label>
                                        <div class="form-input">
                                            <input type="submit" value="<?php echo e(L::_("Submit")); ?>">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-item wleft">
                                <div class="settings-title">
                                    <h3>
                                        <?php echo e(L::_("Your email address")); ?>

                                    </h3>
                                </div>
                                <div class="form-items wleft">
                                    <label class="form-label"><?php echo e(L::_("Current Email")); ?></label>
                                    <div class="form-input">
                                        <span class="show"><?php echo e(userget()->email); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-item wleft">
                                <div class="settings-title">
                                    <h3>
                                        <?php echo e(L::_("Change Your Password")); ?>

                                    </h3>
                                </div>
                                <form ng-submit="changePass(form)" class="ng-pristine ng-valid">
                                    <div class="form-items wleft">
                                        <label class="form-label"><?php echo e(L::_("Current Password")); ?></label>
                                        <div class="form-input">
                                            <input type="password" placeholder="<?php echo e(L::_("Current Password")); ?>"
                                                   ng-model="form.current_password"
                                                   class="ng-pristine ng-untouched ng-valid ng-empty">
                                        </div>
                                    </div>
                                    <div class="form-items wleft">
                                        <label class="form-label"><?php echo e(L::_("New Password")); ?></label>
                                        <div class="form-input">
                                            <input type="password" placeholder="<?php echo e(L::_("New Password")); ?>"
                                                   ng-model="form.new_password"
                                                   class="ng-pristine ng-untouched ng-valid ng-empty">
                                        </div>
                                    </div>
                                    <div class="form-items wleft">
                                        <label class="form-label"><?php echo e(L::_("Comfirm Password")); ?></label>
                                        <div class="form-input">
                                            <input type="password" placeholder="<?php echo e(L::_("Comfirm Password")); ?>"
                                                   ng-model="form.repeat_password"
                                                   class="ng-pristine ng-untouched ng-valid ng-empty">
                                            <div class="message wleft">
                                                <!-- ngIf: p_validate -->
                                                <!-- ngIf: !p_validate --><p ng-if="!p_validate"
                                                                             class="error ng-binding ng-scope"></p>
                                                <!-- end ngIf: !p_validate -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-items wleft">
                                        <label class="form-label"><?php echo e(L::_("Submit")); ?></label>
                                        <div class="form-input">
                                            <input type="submit" value="<?php echo e(L::_("Submit")); ?>">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php echo $__env->make('themes.manga18fx.components.user.right', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-body'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.manga18fx.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/manhuarockz.com/resources/views/themes/manga18fx/pages/profile.blade.php ENDPATH**/ ?>