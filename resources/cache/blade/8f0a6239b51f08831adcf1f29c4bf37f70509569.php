<?php $__currentLoopData = $mangas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <div class="mb-3" >
                    <?php echo e(L::_("Continue Reading")); ?> <a class="font-weight-bold text-danger" style="font-size: 14px"
                           href="<?php echo e($current_reading[$manga->id]->url); ?>"> <?php echo e($current_reading[$manga->id]->name); ?></a>
                </div>


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

<?php /**PATH F:\PHP\HMT\resources\views/themes/manga18fx/template/history-sidebar.blade.php ENDPATH**/ ?>