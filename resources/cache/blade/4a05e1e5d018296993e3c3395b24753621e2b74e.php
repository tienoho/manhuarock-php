

<?php $__env->startSection('title', 'Tìm kiếm truyện nâng cao'); ?>

<?php $__env->startSection('content'); ?>
    <div id="main-wrapper" class="layout-page page-az page-filter">
        <div class="container">

            <div class="prebreadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('home')); ?>"><?php echo e(L::_('Home')); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo e(L::_('Manga Filter')); ?></li>
                    </ol>
                </nav>
            </div>


            <div class="page-search-wrap">
                <!--Begin: Section film list-->
                <section class="block_area block_area_search">
                    <div id="filter-block">
                        <form method="get">
                            <div id="cate-filter" class="category_filter">
                                <div class="category_filter-content mb-5">
                                    <div class="cfc-min-block">
                                        <div class="ni-head mb-3"><strong><?php echo e(L::_('Filter')); ?></strong></div>
                                        <div class="cmb-item cmb-type">
                                            <div class="ni-head"><?php echo e(L::_('Type')); ?></div>
                                            <div class="nl-item">
                                                <div class="nli-select">
                                                    <select class="custom-select" name="type">
                                                        <option value=""><?php echo e(L::_('All')); ?></option>

                                                        <?php $__currentLoopData = allComicType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type_id => $type_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($type === $type_id): ?>
                                                                <option selected value="<?php echo e($type_id); ?>"><?php echo e($type_name); ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo e($type_id); ?>"><?php echo e($type_name); ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="cmb-item cmb-status">
                                            <div class="ni-head"><?php echo e(L::_('Status')); ?></div>
                                            <div class="nl-item">
                                                <div class="nli-select">
                                                    <select class="custom-select" name="status">
                                                        <option value=""><?php echo e(L::_('All')); ?></option>

                                                        <?php $__currentLoopData = allStatus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status_id => $status_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($status === $status_id): ?>
                                                                <option selected value="<?php echo e($status_id); ?>"><?php echo e($status_name); ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo e($status_id); ?>"><?php echo e($status_name); ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="cmb-item cmb-sort">
                                            <div class="ni-head"><?php echo e(L::_('Sort')); ?></div>
                                            <div class="nl-item">
                                                <div class="nli-select">
                                                    <select class="custom-select" name="sort">
                                                        <option selected value="default"><?php echo e(L::_('Default')); ?></option>
                                                        <?php $__currentLoopData = sortType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sort_id => $sort_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($sort === $sort_id): ?>
                                                                <option selected value="<?php echo e($sort_id); ?>"><?php echo e($sort_name); ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo e($sort_id); ?>"><?php echo e($sort_name); ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="cfc-min-block cfc-min-block-genres mt-3">
                                        <div class="ni-head mb-3"><strong><?php echo e(L::_('Genres')); ?></strong></div>
                                        <div class="cmbg-wrap">
                                            <input type="hidden" id="f-genre-ids" name="genres" value="">
                                            <?php $__currentLoopData = Models\Taxonomy::GetListGenres(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <div data-id="<?php echo e($genre->id); ?>"
                                                     class="item f-genre-item <?php if(is_array($genres) && in_array($genre->id, $genres)): ?> active <?php endif; ?>"><?php echo e($genre->name); ?></div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="cfc-button mt-4">
                                        <button class="btn btn-focus new-btn"><strong><?php echo e(L::_('Filter')); ?></strong>
                                        </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="manga_list-sbs">
                                    <div class="block_area-header">
                                        <div class="bah-heading">
                                            <h2 class="cat-heading"><?php echo e(L::_('Filter Results')); ?>

                                                <span class="badge badge-secondary ml-1"
                                                      style="font-size: 12px; vertical-align: middle;"><?php echo e($paginate->total_item); ?></span>
                                            </h2>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="mls-wrap">
                                        <?php $__currentLoopData = $filter_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="item item-spc">

                                                <a class="manga-poster"
                                                   href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>">
                                                    <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                                         data-src="<?php echo e($manga->cover); ?>"
                                                         class="manga-poster-img lazyload"
                                                         alt="<?php echo e($manga->name); ?>">
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
                                                                        <i class="far fa-file-alt mr-2"></i><?php echo e($chapter->name); ?>

                                                                    </a>
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
                            </div>
                        </form>
                    </div>
                </section>
                <!--End: Section film list-->
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-body'); ?>
    <script>
        $('.f-genre-item').click(function () {
            var genreIds = []
            $(this).toggleClass('active');
            $('.f-genre-item').each(function () {
                $(this).hasClass('active') && genreIds.push($(this).data('id'));
            })
            $('#f-genre-ids').val(genreIds.join(','));
        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.mangareader.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/pages/filter.blade.php ENDPATH**/ ?>