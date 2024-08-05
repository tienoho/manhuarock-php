<div class="sidebar-panel ">
    <div class="sidebar-title popular-sidebartt ">
        <h2 class="sidebar-pn-title"><i class="icofont-fire-burn"></i> <?php echo e(L::_("POPULAR MANHWA")); ?></h2>
    </div>
    <div class="sidebar-pp ">
        <?php $__currentLoopData = (new Models\Manga())->trending_manga(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="p-item">
                <a class="pthumb" href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                   title="<?php echo e($manga->name); ?>">
                    <img class="it" data-src="<?php echo e($manga->cover); ?>"
                         src="<?php echo e($manga->cover); ?>" alt="<?php echo e($manga->name); ?>"/>
                </a>
                <div class="p-left">
                    <h4>
                        <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                           title="<?php echo e($manga->name); ?>">
                            <?php echo e($manga->name); ?> </a>
                    </h4>
                    <div class="list-chapter">
                        <?php if(get_manga_data('chapters', $manga->id)): ?>
                            <?php $__currentLoopData = array_slice(get_manga_data('chapters', $manga->id),0,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="chapter-item">
                                                <span class="chapter">
                                                    <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ])); ?>"
                                                       class="btn-link"
                                                       title="<?php echo e($manga->name); ?> <?php echo e($chapter->name); ?>"> <?php echo e($chapter->name); ?> </a>
                                                </span>
                                    <span class="post-on"><?php echo e(time_convert($chapter->last_update)); ?> </span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</div><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/manga18fx/components/popular-sidebar.blade.php ENDPATH**/ ?>