<div id="main-content">
    <!--Begin: Section Manga list-->
    <section class="block_area block_area_fav">
        <div class="block_area-header">
            <div class="float-left bah-heading">
                <h2 class="cat-heading"><?php echo e(L::_('Reading List')); ?></h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="fav-tabs mb-4">
            <ul class="nav nav-tabs pre-tabs pre-tabs-min">

                <li class="nav-item"><a href="<?php echo e(url('user.reading-list')); ?>"
                                        class="nav-link <?php if(!$type): ?> active <?php endif; ?>"><?php echo e(L::_('All')); ?></a></li>

                <?php $__currentLoopData = readingList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reading_type => $reading_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a href="<?php echo e(url('user.reading-list', null, ['type' => $reading_type])); ?>"
                           class="nav-link <?php if($type == $reading_type): ?> active <?php endif; ?>"><?php echo e($reading_name); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>
            <div class="item-order">
                <div class="bhs-item">
                    <div data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="bhsi-name">
                        <?php if(!($sort)): ?>
                            <?php echo e(L::_('Default')); ?>

                        <?php else: ?>
                            <?php echo e(sortName($sort)); ?>

                        <?php endif; ?>
                            <i class="fas fa-angle-down ml-2"></i>
                    </div>
                    <div class="dropdown-menu dropdown-menu-model dropdown-menu-normal" aria-labelledby="ssc-list">
                        <?php if(!($sort)): ?>
                            <a class="dropdown-item added" href="<?php echo e(url('user.reading-list')); ?>">
                                <?php echo e(L::_('Default')); ?> <i class="fas fa-check ml-2"></i>
                            </a>
                        <?php else: ?>
                            <a class="dropdown-item" href="<?php echo e(url('user.reading-list')); ?>">
                                <?php echo e(L::_('Default')); ?>

                            </a>
                        <?php endif; ?>
                        <?php $__currentLoopData = sortType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sort_id => $sort_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($sort !== $sort_id): ?>
                                <a class="dropdown-item "
                                   href="<?php echo e(url('user.reading-list', null, ['sort' => $sort_id])); ?>"><?php echo e($sort_name); ?></a>
                            <?php else: ?>
                                <a class="dropdown-item added"
                                   href="<?php echo e(url('user.reading-list', null, ['sort' => $sort_id])); ?>"><?php echo e($sort_name); ?>

                                    <i class="fas fa-check ml-2"></i></a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="manga_list-sbs">
            <div class="mls-wrap">
                <?php $__currentLoopData = $list_reading; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item item-spc">

                        <div class="dr-fav">
                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                               class="btn btn-circle btn-light btn-fav"><i class="fas fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-model" aria-labelledby="ssc-list">
                                <?php $__currentLoopData = readingList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reading_type => $reading_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="rl-item dropdown-item <?php echo e(($reading_type == $manga->read_type ? 'added' : '')); ?>"
                                       data-type="<?php echo e($reading_type); ?>"
                                       data-manga-id="<?php echo e($manga->id); ?>"
                                       data-page="reading-list"
                                       href="javascript:(0);"><?php echo e($reading_name); ?> <?php if($reading_type == $manga->read_type): ?>
                                            <i class="fas fa-check ml-2"></i> <?php endif; ?>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <a class="rl-item dropdown-item text-danger" href="javascript:(0);"
                                   data-manga-id="<?php echo e($manga->id); ?>"
                                   data-type="0" data-page="reading-list"><?php echo e(L::_('Remove')); ?></a>
                            </div>
                        </div>

                        <a class="manga-poster"
                           href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>">

                            <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                 data-src="<?php echo e($manga->cover); ?>"
                                 class="manga-poster-img lazyload" alt="<?php echo e($manga->name); ?>">
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
                                   href="<?php echo e(url('user.reading-list', null, ['page' => $prev_page, "type" => $type])); ?>">‹</a>
                            </li>
                        <?php endif; ?>

                        <?php for($page_in_loop = 1; $page_in_loop <= $paginate->total_page; $page_in_loop++): ?>
                            <?php if($paginate->total_page > 3): ?>
                                <?php if(( $page_in_loop >= $paginate->current_page - 2 && $page_in_loop <= $paginate->current_page )  || ( $page_in_loop <= $paginate->current_page + 2 && $page_in_loop >= $paginate->current_page)): ?>
                                    <?php if($page_in_loop == $paginate->current_page): ?>
                                        <li class="page-item active">
                                            <a class="page-link" data-page="<?php echo e($paginate->current_page); ?>"
                                               href="<?php echo e(url('user.reading-list', null, ['page' => $paginate->current_page, "type" => $type])); ?>"><?php echo e($paginate->current_page); ?></a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link" data-page="<?php echo e($page_in_loop); ?>"
                                               href="<?php echo e(url('user.reading-list', null, ['page' => $page_in_loop, "type" => $type])); ?>"><?php echo e($page_in_loop); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($page_in_loop == $paginate->current_page): ?>
                                    <li class="page-item active">
                                        <a data-page="<?php echo e($paginate->current_page); ?>"
                                           class="page-link"
                                           href="<?php echo e(url('user.reading-list', null, ['page' => $paginate->current_page, "type" => $type])); ?>"><?php echo e($paginate->current_page); ?></a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item">
                                        <a data-page="<?php echo e($page_in_loop); ?>"
                                           class="page-link"
                                           href="<?php echo e(url('user.reading-list', null, ['page' => $page_in_loop, "type" => $type])); ?>"><?php echo e($page_in_loop); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endfor; ?>


                        <?php if(!($paginate->total_page <= $paginate->current_page)): ?>
                            <?php
                            $next_page = $paginate->current_page + 1;
                            ?>
                            <li class="page-item">
                                <a class="page-link" data-page="1"
                                   href="<?php echo e(url('user.reading-list', null, ['page' => $next_page, "type" => $type])); ?>">›</a>
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
<?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/user/reading-list.blade.php ENDPATH**/ ?>