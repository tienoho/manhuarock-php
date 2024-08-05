<section class="block_area block_area_sidebar block_area-realtime">
    <div class="block_area-header">
        <div class="float-left bah-heading">
            <h2 class="cat-heading"><?php echo e(L::_('You May Also Like')); ?></h2>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="block_area-content">
        <div class="cbox cbox-list cbox-realtime">
            <div class="featured-block-ul">
                <ul class="ulclear">
                    <?php $__currentLoopData = (new \Models\Manga)->RelatedManga(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="item-top">
                            <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                               class="manga-poster">
                                <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                     data-src="<?php echo e($manga->cover); ?>"
                                     class="manga-poster-img lazyload"
                                     alt="<?php echo e($manga->name); ?>">
                            </a>
                            <div class="manga-detail">
                                <h3 class="manga-name">
                                    <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                       title="<?php echo e($manga->name); ?>"><?php echo e($manga->name); ?></a></h3>
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
                                    <div class="d-block">
                                        <?php $__currentLoopData = array_slice(get_manga_data('chapters', $manga->id, []),0 , 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="fdi-item fdi-chapter">
                    <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ])); ?>"><i
                                class="far fa-file-alt mr-2"></i><?php echo e($chapter->name); ?></a>
            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/components/manga/related.blade.php ENDPATH**/ ?>