<div class="modal fade premodal premodal-login" id="modal-auth">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="tab-content">
                <!--Begin: tab login-->
                <div class="tab-pane active" id="modal-tab-login">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modallogintitle">Welcome back!</h5><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" id="login-error" style="display: none;"></div>
                        <form class="preform" id="login-form" method="post" name="login-form">
                            <div class="form-group">
                                <label class="prelabel" for="email">Email address</label> <input class="form-control" id="email" name="email" placeholder="name@email.com" required="" type="text">
                            </div>
                            <div class="form-group">
                                <label class="prelabel" for="password">Password</label> <input class="form-control" id="password" name="password" placeholder="Password" required="" type="password">
                            </div>
                            <div class="form-check custom-control custom-checkbox">
                                <div class="float-left">
                                    <input class="custom-control-input" id="remember" name="remember" type="checkbox"> <label class="custom-control-label" for="remember">Remember me</label>
                                </div>
                                <div class="float-right">
                                    <a class="link-highlight text-forgot forgot-tab-link" href="javascript:;">Forgot password?</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group login-btn mt-4 mb-2">
                                <button class="btn btn-primary btn-block">Sign-in</button>
                                <div class="loading-relative" id="login-loading" style="display: none;">
                                    <div class="loading">
                                        <div class="span1"></div>
                                        <div class="span2"></div>
                                        <div class="span3"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer text-center">
                        Don't have an account? <a class="link-highlight register-tab-link">Register</a>
                    </div>
                </div><!--End: tab login-->
                <!--Begin: tab forgot-->
                <div class="tab-pane fade" id="modal-tab-forgot">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modallogintitle3">Reset Password</h5><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="preform" id="forgot-form" method="post" name="forgot-form">
                            <div class="alert alert-success mb-3" id="forgot-success" style="display:none"></div>
                            <div class="alert alert-danger mb-3" id="forgot-error" style="display:none"></div>
                            <div class="form-group">
                                <label class="prelabel" for="forgot-email">Your Email</label> <input class="form-control" id="forgot-email" name="email" placeholder="name@email.com" required="" type="text">
                            </div>
                            <div class="g-recaptcha mb-3" id="forgot-recaptcha"></div>
                            <div class="form-group login-btn mt-4">
                                <button class="btn btn-primary btn-block">Submit</button>
                                <div class="loading-relative" id="forgot-loading" style="display: none;">
                                    <div class="loading">
                                        <div class="span1"></div>
                                        <div class="span2"></div>
                                        <div class="span3"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer text-center">
                        <a class="link-highlight login-tab-link"><i class="fa fa-angle-left mr-2"></i>Back to Sign-in</a>
                    </div>
                </div><!--End: tab forgot-->
                <!--Begin: tab register-->
                <div class="tab-pane fade" id="modal-tab-register">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modallogintitle2">Create an Account</h5><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" id="register-error" style="display: none;"></div>
                        <form class="preform" id="register-form" method="post" name="register-form">
                            <div class="form-group">
                                <label class="prelabel" for="re-username">Your name</label>
                                <input class="form-control" id="re-username" name="name" placeholder="Name" required="" type="text">
                            </div>
                            <div class="form-group">
                                <label class="prelabel" for="re-email">Email address</label>
                                <input class="form-control" id="re-email" name="email" placeholder="name@email.com" required="" type="text">
                            </div>
                            <div class="form-group">
                                <label class="prelabel" for="re-password">Password</label>
                                <input class="form-control" id="re-password" name="password" placeholder="Password" required="" type="password">
                            </div>
                            <div class="form-group">
                                <label class="prelabel" for="re-confirmpassword">Confirm Password</label>
                                <input class="form-control" id="re-confirmpassword" name="cf_password" placeholder="Confirm Password" required="" type="password">
                            </div>
                            <div class="g-recaptcha mb-3" id="register-recaptcha"></div>
                            <div class="form-group login-btn mt-5 mb-0">
                                <button class="btn btn-primary btn-block">Sign-up</button>
                                <div class="loading-relative" id="register-loading" style="display: none;">
                                    <div class="loading">
                                        <div class="span1"></div>
                                        <div class="span2"></div>
                                        <div class="span3"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer text-center">
                        Have an account? <a class="link-highlight login-tab-link">Sign-in</a>
                    </div>
                </div><!--End: tab register-->
            </div>
        </div>
    </div>
</div><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/components/modal-login.blade.php ENDPATH**/ ?>