


<?php $__env->startSection('content'); ?>
    <div class="content-wrapper pt-3">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mt-1"><i class="fas fa-tools"></i> cài đặt SEO</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill"
                                           href="#meta" role="tab">Thẻ Meta</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill"
                                           href="#slug" role="tab">Slug</a>
                                    </li>

                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="meta"
                                         role="tabpanel">
                                        <form action="/api/meta-setting">
                                            <div class="mt-3 row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="label-row">
                                                            Site Name
                                                        </label>
                                                        <div class="input-group">
                                                            <input
                                                                    value="<?php echo e(getConf('meta')['site_name']); ?>"
                                                                    id="site_name"
                                                                    name="site_name" type="text"
                                                                    class=" form-control form-control-textarea"
                                                                    placeholder="VD: Hội Mê Truyện">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="label-row">
                                                            Home - Title
                                                        </label>
                                                        <div class="input-group">
                                                        <textarea style="width: 100%; min-height: 70px!important;"

                                                                  id="home_title"
                                                                  name="home_title" type="text"
                                                                  class=" form-control form-control-textarea"
                                                                  placeholder="VD: Hoimetruyen - Đọc truyện tranh online"><?php echo e(getConf('meta')['home_title']); ?></textarea>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="label-row">
                                                            Home - Description
                                                        </label>
                                                        <div class="input-group">
                                                        <textarea style="width: 100%; min-height: 70px!important;"
                                                                  id="home_description"
                                                                  name="home_description" type="text"
                                                                  class=" form-control form-control-textarea"
                                                                  placeholder="VD: Kho truyện tranh Online tiếng việt"><?php echo e(getConf('meta')['home_description']); ?></textarea>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="label-row">
                                                            Manga - Title
                                                        </label>
                                                        <div class="input-group">
                                                        <textarea style="width: 100%; min-height: 70px!important;"
                                                                  id="manga_title"
                                                                  name="manga_title" type="text"
                                                                  class="form-control form-control-textarea"
                                                                  placeholder="VD: Đọc truyện %manga_name% mới nhất"><?php echo e(getConf('meta')['manga_title']); ?></textarea>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="label-row">
                                                            Manga - Description
                                                        </label>
                                                        <div class="input-group">
                                                        <textarea style="width: 100%; min-height: 70px!important;"
                                                                  id="manga_description"
                                                                  name="manga_description" type="text"
                                                                  class="form-control form-control-textarea"
                                                                  placeholder="VD: Đọc truyện %manga_name% mới nhất, cập nhật liện tục"><?php echo e(getConf('meta')['manga_description']); ?></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="label-row">
                                                            Chapter - Title
                                                        </label>
                                                        <div class="input-group">
                                                        <textarea style="width: 100%; min-height: 70px!important;"
                                                                  id="chapter_title"
                                                                  name="chapter_title" type="text"
                                                                  class="form-control form-control-textarea"
                                                                  placeholder="VD: Đọc truyện %manga_name% %chapter_name% mới nhất"><?php echo e(getConf('meta')['chapter_title']); ?></textarea>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="label-row">
                                                            Chapter - Description
                                                        </label>
                                                        <div class="input-group">
                                                        <textarea style="width: 100%; min-height: 70px!important;"
                                                                  id="chapter_description"
                                                                  name="chapter_description" type="text"
                                                                  class="form-control form-control-textarea"
                                                                  placeholder="VD: Đọc truyện %manga_name% %chapter_name% mới nhất, cập nhật liện tục"><?php echo e(getConf('meta')['chapter_description']); ?></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" id="submit-meta-setting" class="btn btn-success">Xác
                                                        nhận <span style="display: none"
                                                                   class=" scraper-loading ml-1 spinner-border spinner-border-sm"
                                                                   role="status" aria-hidden="true"></span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="slug"
                                         role="tabpanel">
                                        <form action="/api/slug-setting">
                                            <div class="mt-3 row">
                                                <?php $__currentLoopData = $slugs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="label-row">
                                                                <?php echo e($name); ?>

                                                            </label>
                                                            <div class="input-group">
                                                                <input id="<?php echo e($key); ?>"
                                                                       value="<?php echo e(getConf('slug')[$key]); ?>"
                                                                       name="<?php echo e($key); ?>" type="text"
                                                                       class=" form-control form-control-textarea"
                                                                       placeholder="VD: <?php echo e(trim(path_url($key), '/')); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-12">
                                                        <button type="submit" id="submit-slug-setting" class="btn btn-success">Xác
                                                            nhận <span style="display: none"
                                                                       class=" scraper-loading ml-1 spinner-border spinner-border-sm"
                                                                       role="status" aria-hidden="true"></span></button>
                                                    </div>
                                            </div>
                                        </form>
                                    </div>
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
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/admin/pages/seo-setting.blade.php ENDPATH**/ ?>