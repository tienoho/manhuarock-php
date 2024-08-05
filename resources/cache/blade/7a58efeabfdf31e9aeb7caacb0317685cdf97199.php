<div id="manga-featured">
    <div class="container">
        <section class="block_area block_area_featured">
            <div class="block_area-header">
                <div class="bah-heading">
                    <h2 class="cat-heading"><?php echo e(L::_('Recommended')); ?></h2>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="block_area-content">
                <div class="featured-list featured-03">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php
                            $Cache = Services\Cache::load();
                            $CachedString = $Cache->getItem('recommended.home');
                            if(!$CachedString->isHit()){
                                $data = (new Models\Manga())->recommended(12);
                                $CachedString->set($data)->expiresAfter(500);
                                $Cache->save($CachedString);
                            }

                            ?>
                            <?php $__currentLoopData = $CachedString->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide">
                                <div class="mg-item-basic">
                                    <div class="manga-poster">
                                        <a class="link-mask"
                                           href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"></a>
                                        <?php if((strtotime('now') - strtotime($manga->created_at)) < 60 * 60 *24): ?>
                                        <span class="tick tick-item tick-lang"><?php echo e(L::_('New')); ?></span>
                                        <?php endif; ?>
                                        <div class="mp-desc">
                                            <p class="alias-name mb-2"><strong><?php echo e($manga->name); ?></strong>
                                            </p>
                                            <p><i class="fas fa-eye mr-2"></i><?php echo e($manga->views); ?></p>
                                            <?php if($chapters = get_manga_data('chapters', $manga->id)): ?>
                                                <p>
                                                    <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, "c_slug" => $chapters[0]->slug, "c_id" => $chapters[0]->id])); ?>">
                                                        <i class="far fa-file-alt mr-2"></i><strong><?php echo e($chapters[0]->name); ?></strong></a>
                                                </p>
                                            <?php endif; ?>
                                            <div class="mpd-buttons">
                                                <a class="btn btn-primary btn-sm btn-block"
                                                   href="<?php echo e(url('read_first', ['m_id' => $manga->id])); ?>">
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
                                    <div class="manga-detail">
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
                                                <?php if(!($key + 1 >= $total_genres)): ?>, <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="featured-navi">
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
</div><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/components/home/recommended.blade.php ENDPATH**/ ?>