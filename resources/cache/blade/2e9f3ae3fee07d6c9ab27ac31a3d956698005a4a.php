


<?php $__env->startSection("content"); ?>
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Campaign
                    </h2>
                </div>

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block open-ajax-modal" data-template="modal-add-campaign">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Add new campaign
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon open-ajax-modal" data-template="modal-add-campaign" aria-label="Create new report">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="w-1"></th>
                                        <th class="w-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = (new CrawlHelpers())->scraplist(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crawler): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($crawler); ?></td>

                                            <td>
                                                <a href="#" onclick="getTemplate('modal-edit-campaign', openModalAjax, { name : '<?php echo e($crawler); ?>' })">Edit</a>
                                            </td>
                                            <td>
                                                <a href="#" onclick="getTemplate('modal-config-campaign', openModalAjax, { name : '<?php echo e($crawler); ?>' })">Config</a>
                                            </td>

                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </div>


    <script>
        $( document ).ready(function() {



        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('autosite.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/autosite/campaign.blade.php ENDPATH**/ ?>