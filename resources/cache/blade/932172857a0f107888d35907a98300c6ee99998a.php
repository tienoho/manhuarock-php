<div class="history-lists row">

    <?php $__currentLoopData = $mangas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="history-item mt-2 col-12 col-md-6">
            <div class="row">
                <div class="col-md-3 col-4">
                    <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>">
                        <div class="cover-container">
                            <img class="history-cover" alt="<?php echo e($manga->name); ?>" src="<?php echo e($manga->cover); ?>">
                        </div>
                    </a>

                </div>
                <div class=" col-md-9 col-8 pl-0">
                    <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>">

                        <h3 class="history-name"><?php echo e($manga->name); ?></h3>
                    </a>
                    <div class="continue"><span class="font-weight-bold text-danger"><?php echo e(L::_("Continue Reading")); ?>:</span> <a
                                href="<?php echo e($current_reading[$manga->id]->url); ?>"> <?php echo e($current_reading[$manga->id]->name); ?></a>
                    </div>
                    <div class="list-chapter mt-2">
                        <?php $__currentLoopData = array_slice(get_manga_data('chapters', $manga->id, []),0,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="chapter-item">
                                                    <span class="chapter">
                                                        <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ])); ?>"
                                                           class="btn-link"
                                                           title="<?php echo e($manga->name); ?> <?php echo e($chapter->name); ?>"> <?php echo e($chapter->name); ?> </a>
                                                    </span>
                                <span class="post-on"><?php echo e(time_convert($chapter->last_update)); ?> </span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>
<?php /**PATH /www/wwwroot/2ten.net/resources/views/themes/manga18fx/template/history-page.blade.php ENDPATH**/ ?>