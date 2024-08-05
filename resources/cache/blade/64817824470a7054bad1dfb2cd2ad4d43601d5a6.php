
<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Leech truyện</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('admin')); ?>">Admin</a></li>
                            <li class="breadcrumb-item active">Leech truyện</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mt-1"><i class="fas fa-spider"></i> Leech truyện</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="leechthucong-tab" data-toggle="pill"
                                           href="#leechthucong" role="tab"
                                           aria-controls="leechthucong" aria-selected="true">Leech thủ công</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill"
                                           href="#leechtudong" role="tab"
                                           aria-controls="custom-content-below-profile"
                                           aria-selected="false">Leech tự động</a>
                                    </li>

                                </ul>

                                <div class="tab-content" id="custom-content-below-tabContent">

                                    <div class="tab-pane fade active show" id="leechthucong"
                                         role="tabpanel" aria-labelledby="leechthucong-tab">
                                        <div class="mt-3 row">
                                            <div class="col-12">

                                                <div class="form-group">
                                                    <label>Nguồn</label>
                                                    <select id='sitethucong' class="form-control">
                                                        <?php $__currentLoopData = (new CrawlHelpers())->scraplist(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($site); ?>"><?php echo e(ucfirst($site)); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="label-row">
                                                        URL
                                                    </label>
                                                    <div class="input-group">
                                                        <textarea id='listUrl'
                                                                  style="width: 100%; min-height: 150px!important; max-height: 500px!important;"
                                                                  name="site_url" type="text"
                                                                  class=" form-control form-control-textarea"
                                                                  placeholder="Ex: https://cmanga.b-cdn.net/toi-muon-tro-thanh-co-ay-chi-mot-ngay-15991"></textarea>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-12">
                                                <button type="submit" id="submitleechthucong" class="btn btn-success">Xác nhận <span style="display: none" class=" scraper-loading ml-1 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="leechtudong"
                                         role="tabpanel" aria-labelledby="leechtudong-tab">
                                        <div class="mt-3 row">
                                            <div class="col-12">

                                                <div class="form-group">
                                                    <label>Nguồn</label>
                                                    <select id="sitetudong" class="form-control">
                                                        <?php $__currentLoopData = (new CrawlHelpers())->scraplist(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($site); ?>"><?php echo e(ucfirst($site)); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="label-row">
                                                        Nhập page max
                                                    </label>
                                                    <div class="input-group">
                                                        <input id="page-start" name="start" type="number"
                                                               class=" form-control"
                                                               placeholder="Mặc định: 1">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="label-row">
                                                        Dừng khi quét tới page:
                                                    </label>
                                                    <div class="input-group">
                                                        <input id="page-end" name="end" type="number"
                                                               class=" form-control"
                                                               placeholder="Mặc định: 1">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-12">
                                                <button type="submit" id="submitleechtudong" class="btn btn-success">Xác nhận <span style="display: none" class=" scraper-loading ml-1 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
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

    <script>
        expandTextarea('listUrl');
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/manhuarockz.com/resources/views/admin/pages/scraper-manage.blade.php ENDPATH**/ ?>