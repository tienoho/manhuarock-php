

<?php $__env->startSection("content"); ?>
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Dashboard
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <!-- Content here -->
            <div class="row row-cards">
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                        <span class="bg-red text-white avatar">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-archive"
                               width="24" height="24" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor"
                               fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <rect x="3" y="4" width="18" height="4" rx="2"></rect>
   <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10"></path>
   <line x1="10" y1="12" x2="14" y2="12"></line>
</svg>
                        </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        Logs Failed
                                    </div>
                                    <div class="text-muted">
                                        <?php echo e(Models\Model::getDB()->where('done', 0)->getOne('auto_logs', 'COUNT(id) as total')['total']); ?>

                                        records
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                        <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hammer" width="24" height="24"
     viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none" stroke-linecap="round"
     stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M11.414 10l-7.383 7.418a2.091 2.091 0 0 0 0 2.967a2.11 2.11 0 0 0 2.976 0l7.407 -7.385"></path>
   <path d="M18.121 15.293l2.586 -2.586a1 1 0 0 0 0 -1.414l-7.586 -7.586a1 1 0 0 0 -1.414 0l-2.586 2.586a1 1 0 0 0 0 1.414l7.586 7.586a1 1 0 0 0 1.414 0z"></path>
</svg>                        </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        Fixed
                                    </div>
                                    <div class="text-muted">
                                        <?php echo e(Models\Model::getDB()->where('done', 1)->getOne('auto_logs', 'COUNT(id) as total')['total']); ?>

                                        records
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                        <span class="bg-blue text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-spider" width="24"
                               height="24" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none"
                               stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M5 4v2l5 5"></path>
   <path d="M2.5 9.5l1.5 1.5h6"></path>
   <path d="M4 19v-2l6 -6"></path>
   <path d="M19 4v2l-5 5"></path>
   <path d="M21.5 9.5l-1.5 1.5h-6"></path>
   <path d="M20 19v-2l-6 -6"></path>
   <circle cx="12" cy="15" r="4"></circle>
   <circle cx="12" cy="9" r="2"></circle>
</svg>
                        </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        Total Campaign
                                    </div>
                                    <div class="text-muted">
                                        <?php echo e(count((new CrawlHelpers())->scraplist())); ?> campaign
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                        <span class="bg-yellow text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/message -->
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="24" height="24"
     viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none" stroke-linecap="round"
     stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <rect x="5" y="3" width="14" height="18" rx="2"></rect>
   <line x1="9" y1="7" x2="15" y2="7"></line>
   <line x1="9" y1="11" x2="15" y2="11"></line>
   <line x1="9" y1="15" x2="13" y2="15"></line>
</svg>                        </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        Crawl Queue
                                    </div>
                                    <div class="text-muted">
                                        <?php echo e(Models\Model::getDB()->getOne('crawl_queue', 'COUNT(id) as total')['total']); ?>

                                        waitings
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">
                                    Crawl queue
                                </h3>
                                <p class="card-subtitle">
                                    List of urls waiting to be crawl
                                </p>
                            </div>
                            <div class="card-actions">
                                <a href="#" class="btn btn-primary open-ajax-modal " data-template="modal-add-queue">
                                    Add new URL
                                </a>
                            </div>
                        </div>
                        <div class="card-table table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                <tr>
                                    <th>URL</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = Models\Model::getDB()->objectBuilder()->get('crawl_queue'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                           <?php echo e($queue->url); ?>

                                            <a href="<?php echo e($queue->url); ?>" target="_blank" class="ms-1" aria-label="Open website">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/link -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                     height="24"
                                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                     fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 14a3.5 3.5 0 0 0 5 0l4 -4a3.5 3.5 0 0 0 -5 -5l-.5 .5"></path>
                                                    <path d="M14 10a3.5 3.5 0 0 0 -5 0l-4 4a3.5 3.5 0 0 0 5 5l.5 -.5"></path>
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="text-muted"><?php echo e($queue->source); ?></td>
                                        <td class="text-muted"><?php if($queue->running): ?><span class="badge bg-success me-1"></span> Running <?php else: ?> <span class="badge bg-warning me-1"></span> Waiting <?php endif; ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="row row-cards">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Configuration
                                    </h3>
                                    <div class="card-actions">
                                        <a href="<?php echo e(path_url('autotool') . 'configuration'); ?>">
                                            Edit configuration
                                            <!-- Download SVG icon from http://tabler-icons.io/i/edit -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24"
                                                 height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                                <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                                <line x1="16" y1="5" x2="19" y2="8"></line>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-5">Server Image:</dt>
                                        <dd class="col-7"><?php echo e($tool_config->server_image); ?></dd>

                                        <dt class="col-5">Type Crawl:</dt>
                                        <dd class="col-7"><?php echo e(($tool_config->only_update ? 'Only Update Chap' : 'Crawl ALL')); ?></dd>
                                        <dt class="col-5">Re-Crawl:</dt>
                                        <dd class="col-7"><?php echo e($tool_config->max_page_update); ?> pages</dd>

                                        <dt class="col-5">Running:</dt>
                                        <dd class="col-7"><?php echo e($tool_config->max_process_running); ?> process same time</dd>

                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('autosite.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/autosite/index.blade.php ENDPATH**/ ?>