<div class="deslide-wrap">
    <div class="container">
        <div id="slider">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = (new Models\Manga())->pin_manga(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide <?php echo e(($key == 0 ? 'swiper-slide-active': '')); ?>">
                    <div class="deslide-item">
                        <a class="deslide-cover" href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>">
                            <img alt="<?php echo e($manga->name); ?>"
                                 class="manga-poster-img lazyload"
                                 src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo e($manga->cover); ?>">
                        </a>
                        <div class="deslide-poster">
                            <a class="manga-poster" href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>">
                                <img alt="<?php echo e($manga->name); ?>"
                                     class="manga-poster-img lazyload"
                                     src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo e($manga->cover); ?>"></a>
                        </div>
                        <div class="deslide-item-content">
                            <div class="desi-sub-text">
                                <?php if($chapters = get_manga_data('chapters', $manga->id)): ?>
                                    <?php echo e(str_replace('Chapter ', 'Chương: ', $chapters[0]->name)); ?>

                                <?php endif; ?>
                            </div>
                            <div class="desi-head-title">
                                <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>" title="<?php echo e($manga->name); ?>"><?php echo e($manga->name); ?></a>
                            </div>
                            <div class="sc-detail">
                                <div class="scd-item mb-3">
                                    <?php echo e(limit_text($manga->description, 300)); ?>

                                </div>
                                <div class="scd-item scd-genres">

                                    <?php $__currentLoopData = get_manga_data('genres', $manga->id, []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><?php echo e($genre->name); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="desi-buttons">
                                <a class="btn btn-slide-read mr-2" href="<?php echo e(url('read_first', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"><?php echo e(L::_('Read Now')); ?></a> <a
                                        class="btn btn-slide-info" href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"><?php echo e(L::_('View Info')); ?></a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-navigation">
                <div class="swiper-button swiper-button-next">
                    <i class="fas fa-angle-right"></i>
                </div>
                <div class="swiper-button swiper-button-prev">
                    <i class="fas fa-angle-left"></i>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/home/deslide.blade.php ENDPATH**/ ?>