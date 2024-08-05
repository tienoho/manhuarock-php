

<?php $__env->startSection('title', 'Đăng Nhập'); ?>

<?php $__env->startSection('content'); ?>
    <div class="manga-content wleft">
        <div class="user-content">
            <div class="centernav">
                <div class="c-breadcrumb-wrapper">
                    <div class="c-breadcrumb">
                        <ol class="breadcrumb">
                            <li>
                                <a href="/" title="<?php echo e(L::_("Read Manga Online")); ?>">
                                    <?php echo e(L::_("Home")); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(path_url("login")); ?>" class="active">
                                    <?php echo e(L::_("Login")); ?>

                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="signup-form wleft tcenter">
                    <h1><?php echo e(L::_("Login Your Account")); ?></h1>
                    <form action="/ajax/auth/login" method="POST" id="loginform" class="ng-pristine ng-valid">
                        <div class="field-panel wleft">
                            <i class="icofont-email"></i>
                            <input class="user-name" type="text" name="email"
                                   placeholder="<?php echo e(L::_("Email")); ?>">
                        </div>
                        <div class="field-panel wleft">
                            <i class="icofont-lock"></i>
                            <input class="pass" name="password" placeholder="<?php echo e(L::_("Password")); ?>" type="password">
                        </div>
                        <input name="submit_register" type="submit" id="submit_register" value="<?php echo e(L::_("SIGN IN")); ?>" class="submit">
                        <a class="submit mt-2" style="background-color: #0c84ff" href="<?php echo e($fbLogin); ?>"> <?php echo e(L::_("LOGIN FACEBOOK")); ?> </a>
                    </form>

                    <script type="text/javascript">
                        var frm = $('#loginform');

                        frm.submit(function (e) {

                            e.preventDefault();

                            $.ajax({
                                type: frm.attr('method'),
                                url: frm.attr('action'),
                                data: frm.serialize(),
                                success: function (data) {
                                    var ref = document.referrer;
                                    if(data.status){
                                        if (ref.indexOf(window.location.host)) {
                                            window.location.href = ref;
                                        } else {
                                            window.location.href = window.location.host;
                                        }
                                    } else {
                                        alert(data.msg)
                                    }

                                },
                                error: function (data) {
                                    console.log('An error occurred.');
                                    console.log(data);
                                },
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.manga18fx.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/themes/manga18fx/pages/login.blade.php ENDPATH**/ ?>