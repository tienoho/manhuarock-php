<section class="block_area block_area_sidebar block_area-genres">
    <div class="block_area-header">
        <div class="bah-heading">
            <h2 class="cat-heading"><?php echo e(L::_('Genres')); ?></h2>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="block_area-content">
        <div class="category_block mb-0">
            <div class="c_b-wrap">
                <div class="c_b-list active">
                    <div class="cbl-row">
                        <div class="item item-focus focus-01">
                            <a href="<?php echo e(url('latest-updated')); ?>" title=""><i class="mr-1">⚡</i><?php echo e(L::_('Latest Updated')); ?></a>
                        </div>
                        <div class="item item-focus focus-02">
                            <a href="<?php echo e(url('new-release')); ?>" title=""><i class="mr-1">✌</i><?php echo e(L::_('New Release')); ?></a>
                        </div>
                        <div class="item item-focus focus-04">
                            <a href="<?php echo e(url('most-viewed')); ?>" title=""><i class="mr-1">🔥</i><?php echo e(L::_('Most Viewed')); ?></a>
                        </div>
                        <div class="item item-focus focus-05">
                            <a href="<?php echo e(url('completed')); ?>" title=""><i class="mr-1">✅</i><?php echo e(l::_('Completed')); ?></a>
                        </div>
                    </div>
                    <div class="cbl-row">
                        <?php $__currentLoopData = Models\Taxonomy::GetListGenres(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item">
                            <a href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>" title="<?php echo e($genre->name); ?>"><?php echo e($genre->name); ?></a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="item item-more"><a class="im-toggle">+ More</a></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/components/category-block.blade.php ENDPATH**/ ?>