<div id="main-content">
    <!--Begin: Section Manga list-->
    <section class="block_area block_area_continue">
        <div class="block_area-header block_area-header-tabs">
            <div class="float-left bah-heading">
                <h2 class="cat-heading"><?php echo e(L::_('Continue Reading')); ?></h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="manga_list-continue">
            <div class="mlc-wrap">
                <?php $__currentLoopData = $list_reading; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="item">
                    <div class="ctn-item">
                        <div class="ctn-detail">
                            <div class="manga-poster">
                                <a class="link-mask" href="<?php echo e(url('manga', ['m_id' => $manga->id, 'm_slug' => $manga->slug])); ?>"></a>
                                <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                     data-src="<?php echo e($manga->cover); ?>"
                                     class="manga-poster-img lazyload" alt="<?php echo e($manga->name); ?>">
                            </div>
                            <div class="manga-detail">
                                <div class="dr-remove">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                       class="btn btn-sm btn-remove"><i class="fas fa-ellipsis-v"></i></a>
                                    <div class="dropdown-menu dropdown-menu-model dmm-topright"
                                         aria-labelledby="ssc-list">
                                        <a href="javascript:(0);" data-id="<?php echo e($manga->id); ?>"
                                           class="dropdown-item text-danger btn-remove-cr">Remove</a>
                                    </div>
                                </div>
                                <h3 class="manga-name">
                                    <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                       title="<?php echo e($manga->name); ?>"><?php echo e($manga->name); ?></a>
                                </h3>
                                <div class="fd-infor">
                                    <?php
                                    $genres = array_slice(get_manga_data('genres', $manga->id, []), 0, 2);
                                    $total_genres = count($genres);
                                    $i = 1;
                                    ?>
                                    <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>"><?php echo e($genre->name); ?></a>
                                        <?php if(!($key + 1 >= $total_genres)): ?>,
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $manga->chapter_slug , 'c_id' => $manga->chapter_id])); ?>"
                                   title="<?php echo e($manga->name); ?>" class="reading-load">
                                    <div class="rl-loaded" style="width: 100%;"></div>
                                    <div class="rl-text">
                                        <span>Đọc tiếp </span><?php echo e($manga->chapter_name); ?>

                                    </div>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="loading-absolute bg-white" id="cr-loading-<?php echo e($manga->id); ?>" style="display: none">
                            <div class="loading">
                                <div class="span1"></div>
                                <div class="span2"></div>
                                <div class="span3"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="clearfix"></div>
            </div>
            <div class="pre-pagination mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-lg justify-content-center">
                        <?php if(!($paginate->current_page <= 1)): ?>
                            <?php
                            $prev_page = $paginate->current_page - 1;
                            ?>

                            <li class="page-item">
                                <a class="page-link" data-page="<?php echo e($prev_page); ?>"
                                   href="<?php echo e(url('user.continue-reading', null, ['page' => $prev_page])); ?>">‹</a>
                            </li>
                        <?php endif; ?>

                        <?php for($page_in_loop = 1; $page_in_loop <= $paginate->total_page; $page_in_loop++): ?>
                            <?php if($paginate->total_page > 3): ?>
                                <?php if(( $page_in_loop >= $paginate->current_page - 2 && $page_in_loop <= $paginate->current_page )  || ( $page_in_loop <= $paginate->current_page + 2 && $page_in_loop >= $paginate->current_page)): ?>
                                    <?php if($page_in_loop == $paginate->current_page): ?>
                                        <li class="page-item active">
                                            <a class="page-link" data-page="<?php echo e($paginate->current_page); ?>"
                                               href="<?php echo e(url('user.continue-reading', null, ['page' => $paginate->current_page])); ?>"><?php echo e($paginate->current_page); ?></a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link" data-page="<?php echo e($page_in_loop); ?>"
                                               href="<?php echo e(url('user.continue-reading', null, ['page' => $page_in_loop])); ?>"><?php echo e($page_in_loop); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($page_in_loop == $paginate->current_page): ?>
                                    <li class="page-item active">
                                        <a data-page="<?php echo e($paginate->current_page); ?>"
                                           class="page-link" href="<?php echo e(url('user.continue-reading', null, ['page' => $paginate->current_page])); ?>"><?php echo e($paginate->current_page); ?></a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item">
                                        <a  data-page="<?php echo e($page_in_loop); ?>"
                                           class="page-link" href="<?php echo e(url('user.continue-reading', null, ['page' => $page_in_loop])); ?>"><?php echo e($page_in_loop); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endfor; ?>


                        <?php if(!($paginate->total_page <= $paginate->current_page)): ?>
                            <?php
                            $next_page = $paginate->current_page + 1;
                            ?>
                            <li class="page-item">
                                <a class="page-link" data-page="<?php echo e($next_page); ?>" href="<?php echo e(url('user.continue-reading', null, ['page' => $next_page])); ?>">›</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <!--End: Section Manga list-->
    <div class="clearfix"></div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/user/continue-reading.blade.php ENDPATH**/ ?>