<?php $__currentLoopData = $mangas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="pin-item" data-id="<?php echo e($manga->id); ?>">
        <div class="pin-title"><?php echo e($manga->name); ?></div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php /**PATH /www/wwwroot/v2.manhuarockz.com/resources/views/admin/components/pinlist.blade.php ENDPATH**/ ?>