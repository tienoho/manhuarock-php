
<?php $__env->startSection('title', L::_("Register") . ' - ' .getConf('meta')['site_name']); ?>
<?php $__env->startSection('description', getConf('meta')['home_description']); ?>

<?php $__env->startSection('url', url('register')); ?>

<?php $__env->startSection("head-css"); ?>
    <link href="/kome/assets/css/user.css" rel="stylesheet" type="text/css"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <div class="fed-part-case" id="main-content">
        <div class="wrap-content-part">
            <div class="header-content-part">
                <div class="title text-center"
                     style="width: 100%; font-size: 1.3rem !important;"><?php echo e(L::_("Register")); ?></div>
            </div>
            <div class="body-content-part" style="min-height:700px;">
                <form id="login-form" action="/ajax/auth/register" method="POST">
                    <div class="wrap-form-input">
                        <div class="wrap-input">
                            <div class="wr-input">
                                <input autofocus="" id="name" name="name"
                                       placeholder="Your Name" type="text"></div>
                        </div>
                        <div class="wrap-input">
                            <div class="wr-input">
                                <input autofocus="" id="email" name="email"
                                       placeholder="Email address" type="text"></div>
                        </div>
                        <div class="wrap-input">
                            <div class="wr-input">
                                <input id="password" name="password" placeholder="Password"
                                       type="password">
                            </div>
                        </div>
                        <div class="wrap-input">
                            <div class="wr-input">
                                <input id="cf_password" name="cf_password" placeholder="Confim Password"
                                       type="password">
                            </div>
                            <br class="clear">
                        </div>
                        <div class="wrap-input">
                            <div class="wr-input">
                                <button class="btn btn-secondary" type="submit"><?php echo e(L::_("Submit")); ?></button>
                                <label class="checkbox">
                                    <input id="isRemember" name="isRemember" type="checkbox"
                                           value="2"><?php echo e(L::_("Remember me")); ?></label></div>
                            <div class="wr-input">
                                <a class="pull-left"
                                   href="<?php echo e(url("login")); ?>"><?php echo e(L::_("Back To Login")); ?></a>
                                <br class="clear"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("body-js"); ?>
    <script src="/kome/assets/js/user.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document.documentElement).ready(function () {
            ajaxSubmit("#login-form");
        });

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.kome.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/kome/pages/register.blade.php ENDPATH**/ ?>