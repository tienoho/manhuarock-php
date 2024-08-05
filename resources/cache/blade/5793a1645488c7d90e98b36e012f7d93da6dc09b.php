
<?php $__env->startSection('title', $seo_title . ' - Hội Mê Truyện'); ?>

<?php $__env->startSection('content'); ?>
    <div class="prebreadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="breadcrumb-item" <?php echo e((isset($breadcrumb_item->active) ? 'active' : '')); ?>>
                        <?php if($breadcrumb_item->url): ?>
                            <a href="<?php echo e($breadcrumb_item->url); ?>"><?php echo e($breadcrumb_item->name); ?></a>
                        <?php else: ?>
                            <?php echo e($breadcrumb_item->name); ?>

                        <?php endif; ?>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </nav>
        </div>
    </div>
    <div id="main-wrapper" class="page-layout page-category">
        <div class="container">
            <div id="mw-2col">
                <!--Begin: main-content-->
                <div id="main-content">
                    <!--Begin: Section Manga list-->
                    <section class="block_area block_area_category">
                        <div class="block_area-header">
                            <div class="bah-heading float-left">
                                <h2 class="cat-heading"><?php echo e($heading_title); ?></h2>
                            </div>
                            <?php if($sort !== false): ?>
                            <div class="cate-sort float-right">
                                <div class="cs-item">
                                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-sm btn-sort">
                                        <span class="mr-2"><?php echo e(L::_('Sort')); ?>:</span>
                                        <?php if(!($sort)): ?>
                                            <?php echo e(L::_('Default')); ?>

                                        <?php else: ?>
                                            <?php echo e(sortName($sort)); ?>

                                        <?php endif; ?>
                                        <i class="fas fa-angle-down ml-2"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-model" aria-labelledby="ssc-list">
                                        <?php if(!($sort)): ?>
                                            <a class="dropdown-item added" href="<?php echo e(url($url)); ?>">
                                                <?php echo e(L::_('Default')); ?> <i class="fas fa-check ml-2"></i>
                                            </a>
                                        <?php else: ?>
                                            <a class="dropdown-item" href="<?php echo e(url($url)); ?>">
                                                <?php echo e(L::_('Default')); ?>

                                            </a>
                                        <?php endif; ?>
                                        <?php $__currentLoopData = sortType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sort_id => $sort_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($sort !== $sort_id): ?>
                                                <a class="dropdown-item "
                                                   href="<?php echo e(url($url, null, ['sort' => $sort_id])); ?>"><?php echo e($sort_name); ?></a>
                                            <?php else: ?>
                                                <a class="dropdown-item added"
                                                   href="<?php echo e(url($url, null, ['sort' => $sort_id])); ?>"><?php echo e($sort_name); ?>

                                                    <i class="fas fa-check ml-2"></i></a>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php endif; ?>
                            <div class="clearfix"></div>
                        </div>
                        <div class="manga_list-sbs">
                            <div class="mls-wrap">
                                <?php $__currentLoopData = $mangas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="item item-spc">

                                    <a class="manga-poster" href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo e($manga->cover); ?>" class="manga-poster-img lazyload" alt="<?php echo e($manga->name); ?>">
                                    </a>
                                    <div class="manga-detail">
                                        <h3 class="manga-name">
                                            <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                               title="<?php echo e($manga->name); ?>"><?php echo e($manga->name); ?></a>
                                        </h3>
                                        <div class="fd-infor">

                        <span class="fdi-item fdi-cate">
                                                        <?php
                            $genres = array_slice(get_manga_data('genres', $manga->id, []), 0, 3);
                            $total_genres = count($genres);
                            $i = 1;
                            ?>
                            <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>"><?php echo e($genre->name); ?></a>
                                <?php if(!($key + 1 >= $total_genres)): ?>,
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </span>

                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="fd-list">
                                            <?php $__currentLoopData = get_manga_data('chapters', $manga->id, []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="fdl-item">
                                                    <div class="chapter">
                                                        <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ])); ?>">
                                                            <i class="far fa-file-alt mr-2"></i><?php echo e($chapter->name); ?></a>
                                                    </div>
                                                    <div class="release-time"></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </div>

                                    </div>

                                    <div class="clearfix"></div>
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
                                                   href="<?php echo e(url($url, ['page' => $prev_page], $params)); ?>">‹</a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for($page_in_loop = 1; $page_in_loop <= $paginate->total_page; $page_in_loop++): ?>
                                            <?php if($paginate->total_page > 3): ?>
                                                <?php if(( $page_in_loop >= $paginate->current_page - 2 && $page_in_loop <= $paginate->current_page )  || ( $page_in_loop <= $paginate->current_page + 2 && $page_in_loop >= $paginate->current_page)): ?>
                                                    <?php if($page_in_loop == $paginate->current_page): ?>
                                                        <li class="page-item active">
                                                            <a class="page-link" data-page="<?php echo e($paginate->current_page); ?>"
                                                               href="<?php echo e(url($url,['page' => $paginate->current_page],$params)); ?>"><?php echo e($paginate->current_page); ?></a>
                                                        </li>
                                                    <?php else: ?>
                                                        <li class="page-item">
                                                            <a class="page-link" data-page="<?php echo e($page_in_loop); ?>"
                                                               href="<?php echo e(url($url, ['page' => $page_in_loop], $params)); ?>"><?php echo e($page_in_loop); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if($page_in_loop == $paginate->current_page): ?>
                                                    <li class="page-item active">
                                                        <a data-page="<?php echo e($paginate->current_page); ?>"
                                                           class="page-link"
                                                           href="<?php echo e(url($url, ['page' => $paginate->current_page], $params)); ?>"><?php echo e($paginate->current_page); ?></a>
                                                    </li>
                                                <?php else: ?>
                                                    <li class="page-item">
                                                        <a data-page="<?php echo e($page_in_loop); ?>"
                                                           class="page-link"
                                                           href="<?php echo e(url($url, ['page' => $page_in_loop], $params)); ?>"><?php echo e($page_in_loop); ?></a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endfor; ?>


                                        <?php if(!($paginate->total_page <= $paginate->current_page)): ?>
                                            <?php
                                            $next_page = $paginate->current_page + 1;
                                            ?>
                                            <li class="page-item">
                                                <a class="page-link" data-page="<?php echo e($next_page); ?>"
                                                   href="<?php echo e(url($url, ['page' => $next_page], $params)); ?>">›</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </section>
                    <!--End: Section Manga list-->
                    <div class="clearfix"></div>
                </div>
                <!--/End: main-content-->
                <!--Begin: main-sidebar-->
                <div id="main-sidebar">
                    <?php echo $__env->make('themes.mangareader.components.category-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <!--/End: main-sidebar-->
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-body'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.mangareader.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/pages/manga-list.blade.php ENDPATH**/ ?>