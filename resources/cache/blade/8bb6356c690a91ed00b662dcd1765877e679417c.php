<?php if(input()->value('page') && input()->value('page') == 'read'): ?>
    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-sm hrr-btn <?php if(($type)): ?> active <?php endif; ?>">
        <i class="far fa-bookmark"></i><span class="hrr-name"><?php echo e(L::_('Reading List')); ?></span>
    </a>
<?php else: ?>
    <a aria-expanded="false" aria-haspopup="true" class="btn btn-light btn-fav <?php if(($type)): ?> active <?php endif; ?>" data-toggle="dropdown">
        <i class="far fa-bookmark"></i>
    </a>
<?php endif; ?>


<?php if(!is_login() || !($type)): ?>
    <div aria-labelledby="ssc-list" class="dropdown-menu dropdown-menu-model">
        <?php $__currentLoopData = readingList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reading_type => $reading_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="rl-item dropdown-item" data-manga-id="<?php echo e($manga_id); ?>" data-page="<?php echo e(input()->value('page')); ?>"
               data-type="<?php echo e($reading_type); ?>"
               href="javascript:(0);"><?php echo e($reading_name); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
    <div aria-labelledby="ssc-list" class="dropdown-menu dropdown-menu-model">
        <?php $__currentLoopData = readingList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reading_type => $reading_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="rl-item dropdown-item <?php echo e(($reading_type == $type ? 'added' : '')); ?>"
               data-manga-id="<?php echo e($manga_id); ?>" data-page="<?php echo e(input()->value('page')); ?>" data-type="<?php echo e($reading_type); ?>"
               href="javascript:(0);"><?php echo e($reading_name); ?> <?php if($reading_type == $type): ?> <i class="fas fa-check ml-2"></i> <?php endif; ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <a class="rl-item dropdown-item text-danger" href="javascript:(0);" data-manga-id="<?php echo e($manga_id); ?>" data-type="0" data-page="<?php echo e(input()->value('page')); ?>"><?php echo e(L::_('Remove')); ?></a>
    </div>
<?php endif; ?>
<div class="clearfix"></div><?php /**PATH /www/wwwroot/manhuarockz.com/resources/views/themes/manga18fx/components/ajax/reading-list.blade.php ENDPATH**/ ?>