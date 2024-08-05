<div class="chap-navigation wleft tcenter">
    <select aria-label="select-chap" class="navi-change-chapter">
        <?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option <?php echo e($chapter->id === $chapter_item->id ? 'selected' : ''); ?>

                    data-c="<?php echo e(url('chapter', ["m_slug" => $manga->slug, "c_slug" => $chapter_item->slug, "c_id"=> $chapter_item->id])); ?>">
                <?php echo e($chapter_item->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <div class="navi-change-chapter-btn">
        <a class="navi-change-chapter-btn-prev a-h" href="#"><i class="icofont-swoosh-left"></i> <?php echo e(L::_("PREV CHAPTER")); ?></a>
        <a class="navi-change-chapter-btn-next a-h" href="#"><?php echo e(L::_("NEXT CHAPTER")); ?> <i class="icofont-swoosh-right"></i></a>
    </div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/manga18fx/components/chapter/navigation.blade.php ENDPATH**/ ?>