<?php

$default_config = json_decode(file_get_contents(ROOT_PATH . '/config/auto-manga.json'), true);
$ImageServers = [
    'Local', 'Bunny', 'Aws', 'Tiki'
];

?>



<?php $__env->startSection("content"); ?>
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Configuration
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Default Configuration</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row align-items-end pb-3 pt-3">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Server Image
                                            </label>
                                            <select class="form-select" name="server_image">
                                                <?php $__currentLoopData = $ImageServers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imgsv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($imgsv); ?>" <?php echo e($default_config['server_image'] === $imgsv ? 'selected=""' : ''); ?>><?php echo e($imgsv); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Save Poster To Server
                                            </label>
                                            <select class="form-select" name="save_poster_to_remote">
                                                <?php $__currentLoopData = $ImageServers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imgsv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($imgsv); ?>" <?php echo e($default_config['save_poster_to_remote'] === $imgsv ? 'selected=""' : ''); ?>><?php echo e($imgsv); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">Max Process Running
                                            </label>
                                            <input type="number" class="form-control" name="max_process_running"
                                                   value="<?php echo e($default_config['max_process_running']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">Max Page Update
                                            </label>
                                            <input type="number" class="form-control" name="max_page_update"
                                                   value="<?php echo e($default_config['max_page_update']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <div>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="save_poster" <?php if($default_config['save_poster']): ?> checked=""<?php endif; ?>>
                                                        <span class="form-check-label">Save Poster</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" <?php if($default_config['using_multi_upload']): ?> checked=""<?php endif; ?> disabled="">
                                                        <span class="form-check-label">Multi Upload</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-selectgroup-boxes row">
                                        <div class="col-lg-6">
                                            <label class="form-selectgroup-item mb-2">
                                                <input type="radio" name="only_update" value="1" class="form-selectgroup-input"
                                                       checked="">
                                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                    <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                    </span>
                                    <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Only Update</span>
                                        <span class="d-block text-muted">Tool crawl will only save new chap of existed manga</span>
                                    </span>
                                </span>
                                            </label>
                                        </div>

                                        <div class="col-lg-6 ">
                                            <label class="form-selectgroup-item mb-2">
                                                <input type="radio" name="only_update" value="0" class="form-selectgroup-input">
                                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                    <span class="me-3">
                                        <span class="form-selectgroup-check">
                                        </span>
                                    </span>
                                    <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Crawl All</span>
                                        <span class="d-block text-muted">Tool crawl will scan and save all found manga</span>
                                    </span>
                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="#" class="btn btn-link">Cancel</a>
                                <button type="submit" class="btn btn-primary ms-auto">Send data</button>
                            </div>
                        </div>
                </div>


            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('autosite.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/autosite/configuration.blade.php ENDPATH**/ ?>