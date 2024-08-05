<div id="manga-trending">
    <div class="container">
        <section class="block_area block_area_featured mb-0">
            <div class="block_area-header">
                <div class="bah-heading">
                    <h2 class="cat-heading">Trending</h2>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="block_area-content featured-03">
                <div class="trending-list" id="trending-home">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php $__currentLoopData = (new Models\Manga())->trending_manga(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <div class="item">
                                        <div class="manga-poster">
                                            <a class="link-mask"
                                               href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"></a>

                                            <div class="mp-desc">
                                                <p class="alias-name mb-2"><strong><?php echo e($manga->name); ?></strong></p>
                                                <p><i class="fas fa-star mr-2"></i>N/A</p>
                                                <p><i class="fas fa-eye mr-2"></i><?php echo e($manga->views); ?></p>
                                                <p>
                                                    <?php $chapters = get_manga_data('chapters', $manga->id); ?>
                                                    <?php if($chapters): ?>
                                                    <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, "c_slug" => $chapters[0]->slug, "c_id" => $chapters[0]->id])); ?>">
                                                        <i class="far fa-file-alt mr-2"></i><strong><?php echo e($chapters[0]->name); ?></strong></a>
                                                    <?php endif; ?>
                                                </p>

                                                <div class="mpd-buttons">
                                                    <a class="btn btn-primary btn-sm btn-block"
                                                       href="<?php echo e(url('read_first', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>">
                                                        <i class="fas fa-glasses mr-2"></i><?php echo e(L::_('Read Now')); ?></a>
                                                    <a class="btn btn-light btn-sm btn-block"
                                                       href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"><i
                                                                class="fas fa-info-circle mr-2"></i><?php echo e(L::_('Info')); ?></a>
                                                </div>
                                            </div>
                                            <img alt="<?php echo e($manga->name); ?>" class="manga-poster-img lazyload"
                                                 src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                                 data-src="<?php echo e($manga->cover); ?>">
                                        </div>
                                        <div class="number">
                                            <?php $i = ($i ?? 0) + 1 ?>

                                            <?php if($i <= 9): ?>
                                                <span>0<?php echo e($i); ?></span>
                                            <?php else: ?>
                                                <span><?php echo e($i); ?></span>
                                            <?php endif; ?>
                                            <div class="anime-name">
                                                <?php echo e($manga->name); ?>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="trending-navi">
                        <div class="navi-next">
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <div class="navi-prev">
                            <i class="fas fa-angle-left"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/home/trending.blade.php ENDPATH**/ ?>