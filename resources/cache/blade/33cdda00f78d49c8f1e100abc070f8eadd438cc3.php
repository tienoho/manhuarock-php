<nav class="navbar navbar-expand-sm chap-navigation" data-toggle="affix">
    <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <div class="navi-change-chapter-btn">
                    <a class="navi-change-chapter-btn-prev a-h" href="#"><i class="icofont-swoosh-left"></i></a>
                </div>
            </li>
            <li class="nav-item">
                <select aria-label="select-chap" class="navi-change-chapter">
                    <?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e($chapter->id === $chapter_item->id ? 'selected' : ''); ?>

                                data-c="<?php echo e(url('chapter', ["m_slug" => $manga->slug, "c_slug" => $chapter_item->slug, "c_id"=> $chapter_item->id])); ?>">
                            <?php echo e($chapter_item->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </li>
            <li class="nav-item">
                <div class="navi-change-chapter-btn">
                    <a class="navi-change-chapter-btn-next a-h" href="#"><i class="icofont-swoosh-right"></i></a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<?php /**PATH /www/wwwroot/manhuarockz.com/resources/views/themes/manga18fx/components/chapter/navigation-footer.blade.php ENDPATH**/ ?>