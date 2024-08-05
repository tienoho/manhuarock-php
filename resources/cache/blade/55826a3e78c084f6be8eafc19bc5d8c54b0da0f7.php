<div id="sidebar_menu_bg"></div>
<div id="sidebar_menu">
    <a class="sb-uimode" href="javascript:;" id="sb-toggle-mode"><i class="fas fa-moon mr-2"></i><span class="text-dm">Dark Mode</span><span
                class="text-lm">Light Mode</span></a>
    <button class="btn toggle-sidebar"><i class="fas fa-angle-left"></i></button>
    <ul class="nav sidebar_menu-list">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(url('home')); ?>"><?php echo e(L::_('Home')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:;" title="Types"><?php echo e(L::_('Types')); ?></a>
            <div class="types-sub">
                <?php $__currentLoopData = allComicType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type_id => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a class="ts-item" href="<?php echo e(url('manga.type', ['type' => $type_id])); ?>"><?php echo e($type); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(url('completed')); ?>" title="<?php echo e(L::_('Completed')); ?>"><?php echo e(L::_('Completed')); ?></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(url('filter')); ?>" title="<?php echo e(L::_("Filter")); ?>"><?php echo e(L::_("Filter")); ?></a>
        </li>





        <li class="nav-item">
            <div class="nav-link">
                <strong><?php echo e(L::_("Genres")); ?></strong>
            </div>
            <div class="sidebar_menu-sub">
                <ul class="nav sub-menu">
                    <?php $__currentLoopData = Models\Taxonomy::GetListGenres(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>" title="<?php echo e($genre->name); ?>"><?php echo e($genre->name); ?></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item nav-more">
                        <a class="nav-link"><i class="fas fa-plus mr-2"></i><?php echo e(L::_('More')); ?></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </li>
    </ul>
    <div class="clearfix"></div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/sidebar.blade.php ENDPATH**/ ?>