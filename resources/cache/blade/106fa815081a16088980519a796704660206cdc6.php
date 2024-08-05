<div class="row">
    <div class="col-12 mb-3">
        <form METHOD="GET">
            <div class="input-group">
                <input type="search" PLACEHOLDER="Tìm kiếm" value="<?php echo e(input()->value('s')); ?>" name="s" class="form-control"/>

                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>


    <?php if($taxonomys): ?>

        <?php $__currentLoopData = $taxonomys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxonomy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 border-bottom pt-2 pb-2 taxonomy-item" data-id="<?php echo e($taxonomy->id); ?>">
                <div class="text-bold text-info " >
                    <?php echo e($taxonomy->name); ?>

                    <a data-id="<?php echo e($taxonomy->id); ?>" class="ml-2 btn btn-xs btn-success edit-taxonomy">
                        <i class="fas fa-pen"></i></a>
                    <div class="btn btn-xs btn-danger delete-taxonomy">
                        <i class="fas fa-trash"></i></div>
                </div>


                <div>
                    <span class="text-bold"> Mô tả: </span> <?php echo e($taxonomy->description); ?>

                </div>
            </div>


        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="col-12">Không có dữ liệu</div>
    <?php endif; ?>
</div>
<?php /**PATH /www/wwwroot/2ten.net/resources/views/admin/components/taxonomy/detail-list.blade.php ENDPATH**/ ?>