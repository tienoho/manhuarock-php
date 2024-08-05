<div class="list-search">
    <?php $__currentLoopData = $mangas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="search-item" data-id="<?php echo e($manga->id); ?>">
        <div class="search-title"><?php echo e($manga->name); ?></div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<style>
    .list-search {
        cursor: pointer;

    }
    .search-item {
        margin: 15px 5px;
    }

    .search-item:hover {
        color: #0c84ff;
    }

    .search-title {
        font-weight: 600;
    }
</style><?php /**PATH /www/wwwroot/2ten.net/resources/views/admin/components/pinsearch.blade.php ENDPATH**/ ?>