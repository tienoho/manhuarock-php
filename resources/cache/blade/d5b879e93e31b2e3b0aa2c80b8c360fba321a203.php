<div id="main-content">
    <section id="chapters-list" class="block_area block_area_category block_area_chapters">
        <div id="list-chapter" class="tab-pane active show">
            <div class="chapter-section">
                <div class="chapter-s-lang">
                    <button type="button" class="btn btn-sm">
                        <i class="far fa-file-alt mr-2"></i>
                        <span><?php echo e(($total_chapters = count($chapters))); ?> <?php echo e(L::_("chapters")); ?></span>
                    </button>

                </div>
                <div class="chapter-s-search">
                    <form class="preform search-reading-item-form">
                        <div class="css-icon"><i class="fas fa-search"></i></div>
                        <input class="form-control search-reading-item" type="text" placeholder="<?php echo e(L::_('Number of Chapter')); ?>" autofocus="">
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="chapters-list-ul">
                <ul class="ulclear reading-list lang-chapters active">
                    <?php
                    ($total_chapters = count($chapters));

                    $total_chapters = $total_chapters + 1;
                    ?>
                    <?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="item reading-item chapter-item " data-number="<?php echo e(($total_chapters = $total_chapters - 1)); ?>">
                        <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_id' => $chapter->id, 'c_slug' => $chapter->slug])); ?>" class="item-link <?php echo e(((isset($chapter->has_read) && $chapter->has_read) != 0 ? 'visited': '')); ?>" title="<?php echo e($chapter->name); ?>">
                            <span class="arrow mr-2"><i class="far fa-file-alt"></i></span>
                            <span class="name"><?php echo e($chapter->name); ?></span>

                            <?php if((!$chapter->price || $chapter->price <= 0 )): ?> <span class="item-read">
                                <i class="fas fa-glasses mr-1"></i> <?php echo e(L::_('Free')); ?> </span>
                                <?php elseif(isset($chapter->is_unlocked) && $chapter->is_unlocked): ?>
                                <span class="item-read">
                                    <i class="fas fa fa-unlock text-success mr-1"></i> <?php echo e(L::_('View')); ?>


                                </span>

                                <?php else: ?>
                                <span class="item-read">
                                    <i class="fas fa fa-lock text-danger mr-1"></i> <?php echo e(L::_('Paid')); ?>

                                </span>
                                <?php endif; ?>
                        </a>
                        <div class="clearfix"></div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>

    <div class="ads-content">
        <!-- Banner ngang -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9778931209315986" data-ad-slot="6419846843" data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});

        </script>
    </div>
    <div class="clearfix"></div>
</div>
<?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/manga/main-content.blade.php ENDPATH**/ ?>