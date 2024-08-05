<?php if(!empty($mangas)): ?>
    <?php $__currentLoopData = $mangas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(manga_url($manga)); ?>" class="nav-item">
        <div class="manga-poster"><img
                    src="<?php echo e($manga->cover); ?>"
                    class="manga-poster-img" alt="<?php echo e($manga->name); ?>"/></div>
        <div class="srp-detail">
            <h3 class="manga-name"><?php echo e($manga->name); ?></h3>
            <div class="film-infor">
                <span>
                    <?php if($chapters = get_manga_data('chapters', $manga->id)): ?>
                                    <?php echo e($chapters[0]->name); ?>

                    <?php endif; ?>
                </span>
            </div>
        </div>
        <div class="clearfix"></div>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <a href="<?php echo e(url('search', [], ['keyword' => $keyword])); ?>" class="nav-item nav-bottom"> <?php echo e(L::_("View all results")); ?><i
                class="fa fa-angle-right ml-2"></i> </a>
<?php else: ?>
    <a href="javascript:(0);" class="nav-item">
        <span><?php echo e(L::_('No results found!')); ?></span>
        <div class="clearfix"></div>
    </a>
<?php endif; ?><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/ajax/suggest.blade.php ENDPATH**/ ?>