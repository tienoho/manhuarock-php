<?php
$name = strtolower(input()->value('name'));

$default_config = json_decode(file_get_contents(ROOT_PATH . '/config/auto-manga.json'), true);
$private_config = [];

$campaign_config_file = ROOT_PATH . "/config/auto-manga-$name.json";

if (file_exists($campaign_config_file)) {
    $private_config = json_decode(file_get_contents($campaign_config_file), true);
}

foreach ($default_config as $config_key => $config_value) {
    if (empty($private_config[$config_key])) {
        $private_config[$config_key] = $config_value;
    }
}

$ImageServers = [
    'Local', 'Bunny', 'Aws', 'Tiki'
];

?>

<!-- Add New Campaign -->
<div class="modal modal-blur fade" id="modal-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Config Campaign: <?php echo e($name); ?>

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input hidden="hidden" value="<?php echo e($name); ?>" name="name">
                    <div class="row mb-3 align-items-end">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Server Image
                                </label>
                                <select class="form-select" name="server_image">
                                    <?php $__currentLoopData = $ImageServers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imgsv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($imgsv); ?>" <?php echo e($private_config['server_image'] === $imgsv ? 'selected=""' : ''); ?>><?php echo e($imgsv); ?>

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
                                        <option value="<?php echo e($imgsv); ?>" <?php echo e($private_config['save_poster_to_remote'] === $imgsv ? 'selected=""' : ''); ?>><?php echo e($imgsv); ?>

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
                                       value="<?php echo e($private_config['max_process_running']); ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Max Page Update
                                </label>
                                <input type="number" class="form-control" name="max_page_update"
                                       value="<?php echo e($private_config['max_page_update']); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="save_poster" <?php if($private_config['save_poster']): ?> checked=""<?php endif; ?>>
                                            <span class="form-check-label">Save Poster</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" <?php if($private_config['using_multi_upload']): ?> checked=""<?php endif; ?> disabled="">
                                            <span class="form-check-label">Multi Upload</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-selectgroup-boxes row mb-3">
                            <div class="col-lg-6">
                                <label class="form-selectgroup-item mb-2">
                                    <input type="radio" name="only_update" value="1" class="form-selectgroup-input"
                                           <?php if($private_config['only_update']): ?> checked=""<?php endif; ?>>
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
                                    <input type="radio" name="only_update" value="0" class="form-selectgroup-input"
                                           <?php if(!$private_config['only_update']): ?> checked=""<?php endif; ?>>
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
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close
                </button>
                <button type="button" class="btn btn-primary" id="submit-config">Submit Config
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var $modal_ajax = $("#modal-ajax");
    var $modal_content = $modal_ajax.find(".modal-content");


    $("#submit-config").click(function () {
        var $form = $modal_content.find("form")
        var data = $form.serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        console.log(data)

        $.post(base_url + '/change-config', data).done(function (res) {
            console.log(res);
            if(res.status){
                alert("Updated successful!");
            }
        })

    });

</script><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/autosite/template/modal-config-campaign.blade.php ENDPATH**/ ?>