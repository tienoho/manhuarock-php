<div id="main-sidebar">
    <!--<div class="ads-content">-->
    <!-- Banner ngang -->
    <!--<ins class="adsbygoogle"-->
    <!-- style="display:block"-->
    <!-- data-ad-client="ca-pub-9778931209315986"-->
    <!-- data-ad-slot="9616776273"-->
    <!-- data-ad-format="auto"-->
    <!-- data-full-width-responsive="true"></ins>-->
    <!--<script>-->
    <!--    (adsbygoogle = window.adsbygoogle || []).push({});-->
    <!--</script>-->
    <!--</div>-->
    <section class="block_area block_area_sidebar block_area-realtime">
        <div class="block_area-header">
            <div class="float-left bah-heading">
                <h2 class="cat-heading"><?php echo e(L::_('Most Viewed')); ?></h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="block_area-content">
            <div class="cbox cbox-list cbox-realtime">
                <div class="cbox-content">
                    <ul class="nav nav-pills nav-fill nav-tabs anw-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#chart-today"><?php echo e(L::_('Today')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#chart-week"><?php echo e(L::_('Week')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#chart-month"><?php echo e(L::_('Month')); ?></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="chart-today">
                            <div class="featured-block-ul featured-block-chart">
                                <ul class="ulclear">
                                    <?php $__currentLoopData = (new Models\Manga())->top_views('views_day', 10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $i = ($i ?? 0) + 1 ?>

                                        <?php if($i <= 3): ?>
                                            <li class="item-top">
                                        <?php else: ?>
                                            <li>
                                                <?php endif; ?>
                                                <div class="ranking-number">
                                                    <?php if($i <= 9): ?>
                                                        <span>0<?php echo e($i); ?></span>
                                                    <?php else: ?>
                                                        <span><?php echo e($i); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <a class="manga-poster" href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"><img
                                                            alt="<?php echo e($manga->name); ?>"
                                                            class="manga-poster-img lazyload"
                                                            src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                                            data-src="<?php echo e($manga->cover); ?>"></a>
                                                <div class="manga-detail">
                                                    <h3 class="manga-name">
                                                        <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                                           title="T<?php echo e($manga->name); ?>"><?php echo e($manga->name); ?></a></h3>
                                                    <div class="fd-infor">
                                                        <span class="fdi-item"><?php echo e($manga->type ?? L::_('Webtoon')); ?></span>
                                                        <span class="dot"></span>
                                                        <span class="fdi-item fdi-cate">
                                                             <?php
                                                            $genres = array_slice(get_manga_data('genres', $manga->id, []), 0, 2);
                                                            $total_genres = count($genres);
                                                            ?>
                                                            <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <a href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>"><?php echo e($genre->name); ?></a>
                                                                <?php if(!($key + 1 >= $total_genres)): ?>, <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                         </span>
                                                        <span class="fdi-item fdi-view"><?php echo e($manga->views_day); ?> <?php echo e(L::_('views')); ?></span>
                                                        <div class="d-block">
                                                            <?php if($chapters = get_manga_data('chapters', $manga->id)): ?>
                                                                <span class="fdi-item fdi-chapter">
                                                                    <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, "c_slug" => $chapters[0]->slug, "c_id" => $chapters[0]->id])); ?>">
                                                                        <i class="far fa-file-alt mr-2"></i><?php echo e($chapters[0]->name); ?></a>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="chart-week">
                            <div class="featured-block-ul featured-block-chart">
                                <ul class="ulclear">
                                    <?php $__currentLoopData = (new Models\Manga())->top_views('views_week', 10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $i = ($i >= 10 ? 0 : $i) + 1 ?>

                                        <?php if($i <= 3): ?>
                                            <li class="item-top">
                                        <?php else: ?>
                                            <li>
                                                <?php endif; ?>
                                                <div class="ranking-number">
                                                    <?php if($i <= 9): ?>
                                                        <span>0<?php echo e($i); ?></span>
                                                    <?php else: ?>
                                                        <span><?php echo e($i); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <a class="manga-poster" href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"><img
                                                            alt="<?php echo e($manga->name); ?>"
                                                            class="manga-poster-img lazyload"
                                                            src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                                            data-src="<?php echo e($manga->cover); ?>"></a>
                                                <div class="manga-detail">
                                                    <h3 class="manga-name">
                                                        <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                                           title="T<?php echo e($manga->name); ?>"><?php echo e($manga->name); ?></a></h3>
                                                    <div class="fd-infor">
                                                        <span class="fdi-item"><?php echo e($manga->type ?? L::_('Webtoon')); ?></span>
                                                        <span class="dot"></span>
                                                        <span class="fdi-item fdi-cate">
                                                             <?php
                                                            $genres = array_slice(get_manga_data('genres', $manga->id, []), 0, 2);
                                                            $total_genres = count($genres);
                                                            ?>
                                                            <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <a href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>"><?php echo e($genre->name); ?></a>
                                                                <?php if(!($key + 1 >= $total_genres)): ?>, <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                         </span>
                                                        <span class="fdi-item fdi-view"><?php echo e($manga->views_week); ?> <?php echo e(L::_('views')); ?></span>
                                                        <div class="d-block">
                                                            <?php if($chapters = get_manga_data('chapters', $manga->id)): ?>
                                                                <span class="fdi-item fdi-chapter">
                                                                    <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, "c_slug" => $chapters[0]->slug, "c_id" => $chapters[0]->id])); ?>">
                                                                        <i class="far fa-file-alt mr-2"></i><?php echo e($chapters[0]->name); ?></a>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="chart-month">
                            <div class="featured-block-ul featured-block-chart">
                                <ul class="ulclear">
                                    <?php $__currentLoopData = (new Models\Manga())->top_views('views_month', 10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $i = ($i >= 10 ? 0 : $i) + 1 ?>

                                        <?php if($i <= 3): ?>
                                            <li class="item-top">
                                        <?php else: ?>
                                            <li>
                                                <?php endif; ?>
                                                <div class="ranking-number">
                                                    <?php if($i <= 9): ?>
                                                        <span>0<?php echo e($i); ?></span>
                                                    <?php else: ?>
                                                        <span><?php echo e($i); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <a class="manga-poster" href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"><img
                                                            alt="<?php echo e($manga->name); ?>"
                                                            class="manga-poster-img lazyload"
                                                            src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                                            data-src="<?php echo e($manga->cover); ?>"></a>
                                                <div class="manga-detail">
                                                    <h3 class="manga-name">
                                                        <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                                           title="T<?php echo e($manga->name); ?>"><?php echo e($manga->name); ?></a></h3>
                                                    <div class="fd-infor">
                                                        <span class="fdi-item"><?php echo e($manga->type ?? L::_('Webtoon')); ?></span>
                                                        <span class="dot"></span>
                                                        <span class="fdi-item fdi-cate">
                                                             <?php
                                                            $genres = array_slice(get_manga_data('genres', $manga->id, []), 0, 2);
                                                            $total_genres = count($genres);
                                                            ?>
                                                            <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <a href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>"><?php echo e($genre->name); ?></a>
                                                                <?php if(!($key + 1 >= $total_genres)): ?>, <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                         </span>
                                                        <span class="fdi-item fdi-view"><?php echo e($manga->views_month); ?> <?php echo e(L::_('views')); ?></span>
                                                        <div class="d-block">
                                                            <?php if($chapters = get_manga_data('chapters', $manga->id)): ?>
                                                                <span class="fdi-item fdi-chapter">
                                                                    <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, "c_slug" => $chapters[0]->slug, "c_id" => $chapters[0]->id])); ?>">
                                                                        <i class="far fa-file-alt mr-2"></i><?php echo e($chapters[0]->name); ?></a>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </section>
</div><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/components/home/main-sidebar.blade.php ENDPATH**/ ?>