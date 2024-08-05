

<?php $__currentLoopData = glob(ROOT_PATH. '/resources/views/ads/*.blade.php'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filename): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('ads.'. str_replace('.blade.php', '', basename($filename)), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper mt-3">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mt-1"><i class="fas fa-tools"></i> cài đặt ADS</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill"
                                           href="#banner" role="tab">Banner</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill"
                                           href="#custom" role="tab">Custom</a>
                                    </li>

                                </ul>

                                <div class="tab-content">

                                    <div class="tab-pane fade active show" id="banner"
                                         role="tabpanel">
                                        <div class="mt-3 row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="label-row">
                                                        Banner Ngang (728 x 90)
                                                    </label>
                                                    <div class="input-group">
                                                        <textarea style="width: 100%; min-height: 150px!important; max-height: 500px!important;"
                                                                  id="banner_ngang"
                                                                  name="banner_ngang" type="text"
                                                                  class=" form-control form-control-textarea"
                                                                  placeholder="Dán mã quảng cáo của bạn tại đây"><?php echo $__env->yieldContent('banner-ngang'); ?></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="label-row">
                                                        Banner Sidebar (300 x 250)
                                                    </label>
                                                    <div class="input-group">
                                                        <textarea style="width: 100%; min-height: 150px!important; max-height: 500px!important;"
                                                                  id="banner_sidebar"
                                                                  name="banner_sidebar" type="text"
                                                                  class=" form-control form-control-textarea"
                                                                  placeholder="Dán mã quảng cáo của bạn tại đây"><?php echo $__env->yieldContent('banner-sidebar'); ?></textarea>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-12">
                                                <button type="submit" id="submit-banner-ads" class="btn btn-success">Xác nhận <span style="display: none" class=" scraper-loading ml-1 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="custom"
                                         role="tabpanel">
                                        <div class="mt-3 row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="label-row">
                                                        Head Code
                                                    </label>
                                                    <div class="input-group">
                                                        <textarea style="width: 100%; min-height: 150px!important; max-height: 500px!important;"
                                                                  id="jshead"
                                                                  name="jshead" type="text"
                                                                  class=" form-control form-control-textarea"
                                                                  placeholder="Mã js trước thẻ </head>"><?php echo $__env->yieldContent('head'); ?></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="label-row">
                                                        Body Code
                                                    </label>
                                                    <div class="input-group">
                                                        <textarea style="width: 100%; min-height: 150px!important; max-height: 500px!important;"
                                                                  id="jsbody"
                                                                  name="jsbody" type="text"
                                                                  class=" form-control form-control-textarea"
                                                                  placeholder="Mã js trước thẻ </body>"><?php echo $__env->yieldContent('body'); ?></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <button type="submit" id="submit-custom-ads" class="btn btn-success">Xác nhận <span style="display: none" class=" scraper-loading ml-1 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <div id="scraper-response">
                                    Chưa có dữ liệu
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/2ten.net/resources/views/admin/pages/ads-setting.blade.php ENDPATH**/ ?>