<div id="main-content">
    <!--Begin: Section Manga list-->
    <section class="block_area block_area_home">
        <div class="block_area-header block_area-header-tabs">
            <div class="float-left bah-heading">
                <h2 class="cat-heading"><?php echo e(L::_('Comic List')); ?></h2>
            </div>
            <div class="bah-tab">
                <ul class="nav nav-tabs pre-tabs pre-tabs-min">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#latest-update"><?php echo e(L::_('Latest Updated')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#latest-manga"><?php echo e(L::_('Latest Comic')); ?></a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="tab-content">
            <div class="tab-pane active show" id="latest-update">
                <div class="manga_list-sbs">
                    <div class="mls-wrap">
                        <?php 
                        $max_update_item = 12;
                        $new_updates = (new Models\Manga())->new_update(1, $max_update_item);


                        ?>
                        <?php $__currentLoopData = $new_updates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="item item-spc">
                            <a class="manga-poster" href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>">
                                <img alt="<?php echo e($manga->name); ?>" class="manga-poster-img lazyload" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo e($manga->cover); ?>"></a>
                            <div class="manga-detail">
                                <h3 class="manga-name">
                                    <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>" title="<?php echo e($manga->name); ?>"><?php echo e($manga->name); ?></a>
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

                                <li class="page-item active">
                                    <a class="page-link" data-page="1" href="<?php echo e(url('latest-updated', ['page' => 1])); ?>">1</a>
                                </li>

                                <?php if(count($new_updates) > $max_update_item): ?>

                                <li class="page-item">
                                    <a class="page-link" data-page="2" href="<?php echo e(url('latest-updated', ['page' => 2])); ?>">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" data-page="3" href="<?php echo e(url('latest-updated', ['page' => 3])); ?>">3</a>
                                </li>


                                <li class="page-item">
                                    <a class="page-link" data-page="2" href="<?php echo e(url('latest-updated', ['page' => 2])); ?>">›</a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="latest-manga">
                <div class="manga_list-sbs">
                    <div class="mls-wrap">
                        <?php 
                            $max_new_item = 12;
                            $new_mangas = (new Models\Manga())->new_manga(1, $max_new_item) ?>


                        <?php $__currentLoopData = $new_mangas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item item-spc">
                            <a class="manga-poster" href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>">
                                
                                <img alt="<?php echo e($manga->name); ?>" class="manga-poster-img lazyload" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo e($manga->cover); ?>"></a>
                            <div class="manga-detail">
                                <h3 class="manga-name">
                                    <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>" title="<?php echo e($manga->name); ?>"><?php echo e($manga->name); ?></a>
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
                                    <div class="clearfix">

                                    </div>
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

                                <li class="page-item active">
                                    <a class="page-link" data-page="1" href="<?php echo e(url('new-release', ['page' => 1])); ?>">1</a>
                                </li>
                                <?php if(count($new_mangas) > $max_new_item): ?>
                                <li class="page-item">
                                    <a class="page-link" data-page="2" href="<?php echo e(url('new-release', ['page' => 2])); ?>">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" data-page="3" href="<?php echo e(url('new-release', ['page' => 3])); ?>">3</a>
                                </li>


                                <li class="page-item">
                                    <a class="page-link" data-page="2" href="<?php echo e(url('new-release', ['page' => 2])); ?>">›</a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--End: Section Manga list-->
    <div class="clearfix"></div>
</div>
<?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/home/main-content.blade.php ENDPATH**/ ?>