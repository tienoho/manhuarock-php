<div style="display: none" class="rt-item rt-lang">
    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn"
            id="c-selected-lang"></button>
    <div class="dropdown-menu dropdown-menu-model" aria-labelledby="ssc-list">
        <a data-code="en" data-type="chap"
           class="dropdown-item lang-item c-select-lang"
           href="javascript:;">[VN] VietNam</a>
    </div>
</div>
<div class="rt-item rt-chap" id="dropdown-chapters">
    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn">
        <span
                id="current-chapter"></span><i class="fas fa-angle-down ml-2"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-model dropdown-menu-fixed" aria-labelledby="ssc-list">
        <div class="chapter-list-read">
            <div class="chapter-section">
                <div class="chapter-s-search">
                    <form class="preform search-reading-item-form">
                        <div class="css-icon"><i class="fas fa-search"></i></div>
                        <input class="form-control search-reading-item" type="text" placeholder="Number of Chapter"
                               autofocus="autofocus" autocomplete="off">
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="chapters-list-ul">
                <ul class="ulclear reading-list lang-chapters" id="en-chapters" style="display:none;">
                    <?php
                    $total = count($chapters) + 1;
                    ?>
                    <?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="item reading-item chapter-item" data-id="<?php echo e($chapter->id); ?>" data-number="<?php echo e(($total = $total - 1)); ?>" data-reading-mode="0">
                        <a href="<?php echo e(path_url('chapter', ['m_slug' => $manga_slug, 'c_id' => $chapter->id, 'c_slug' => $chapter->slug])); ?>" title="<?php echo e($chapter->name); ?>"
                           class="item-link <?php echo e(((isset($chapter->has_read) && $chapter->has_read) != 0 ? 'visited': '')); ?>" data-shortname="<?php echo e((explode(':', $chapter->name)[0])); ?>"> <span class="arrow mr-2"><i
                                        class="fas fa-caret-right"></i></span> <span class="name"><?php echo e($chapter->name); ?></span>
                        </a>
                        <div class="clearfix"></div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/components/chapter/reading-list.blade.php ENDPATH**/ ?>