<div id="ani_detail">
    <div class="ani_detail-stage">
        <div class="container">
            <div class="detail-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('home')); ?>"><?php echo e(L::_('Home')); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo e($manga->name); ?></li>
                    </ol>
                </nav>
            </div>
            <div class="anis-content">
                <div class="anisc-poster">
                    <div class="manga-poster">
                        <img id="primaryimage"
                             src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                             data-src="<?php echo e($manga->cover); ?>" class="manga-poster-img lazyload"
                             alt="<?php echo e($manga->name); ?>">
                    </div>
                </div>
                <div class="anisc-detail">
                    <h1 class="manga-name"><?php echo e($manga->name); ?></h1>
                    <div class="manga-name-or"><?php echo e($manga->other_name ?? $manga->name); ?></div>
                    <div class="manga-buttons">
                        <a href="<?php echo e(url('read_first', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                           class="btn btn-primary btn-play smoothlink"><i
                                    class="fas fa-eye mr-2"></i><?php echo e(L::_('Read Now')); ?></a>
                        <div class="dr-fav" id="reading-list-info">
                            <a aria-expanded="false" aria-haspopup="true" class="btn btn-light btn-fav "
                               data-toggle="dropdown"><i class="far fa-bookmark"></i> </a>
                        </div>
                    </div>
                    <div class="sort-desc">
                        <div class="genres">
                            <?php $__currentLoopData = get_manga_data('genres', $manga->id, []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>"><?php echo e($genre->name); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>

                        <?php if(!empty(trim($manga->description))): ?>
                            <div class="description">
                                <?php echo nl2br(trim($manga->description)); ?>

                            </div>
                            <div class="description-more">
                                <button type="button" data-toggle="modal" data-target="#modaldesc"
                                        class="btn btn-xs text-white">+ <?php echo e(L::_('Read full')); ?>

                                </button>
                            </div>
                        <?php else: ?>
                            <div class="description">
                            Đọc <b><?php echo e($manga->name); ?></b> truyện tranh có nét vẽ đẹp sắc nét, nội dung hấp dẫn.
                            Đọc truyện <b><?php echo e(mb_strtoupper($manga->other_name ?? $manga->name)); ?></b> chap mới nhất ngang raw tại hoimetruyen.com
                            </div>
                        <?php endif; ?>

                        <div class="anisc-info-wrap">
                            <div class="anisc-info">
                                <div class="item item-title">
                                    <span class="item-head"><?php echo e(L::_('Type')); ?>:</span>
                                    <a class="name"
                                       href="<?php echo e(($manga->type ? url('manga.type', ['type' => $manga->type]) : '#')); ?>"><?php echo e(type_name($manga->type)); ?></a>
                                </div>
                                <div class="item item-title">
                                    <span class="item-head"><?php echo e(L::_('Status')); ?>:</span>
                                    <span class="name"><?php echo e(status_name($manga->status)); ?></span>
                                </div>

                                <?php if(!empty(($authors = get_manga_data('authors', $manga->id, [])))): ?>
                                    <div class="item item-title">
                                        <span class="item-head"><?php echo e(L::_('Authors')); ?>:</span>
                                        <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(url('authors', ['authors' => $author->slug])); ?>"><?php echo e($author->name); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="item item-title">
                                    <span class="item-head"><?php echo e(L::_('Published')); ?>:</span>
                                    <span class="name"><?php echo e(timeago($manga->created_at)); ?></span>
                                </div>
                                <?php if(!empty(($tartists = get_manga_data('artists', $manga->id, [])))): ?>
                                    <div class="item item-title">
                                        <span class="item-head"><?php echo e(L::_('Translation')); ?>:</span>
                                        <?php $__currentLoopData = $tartists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tartist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(url('artists', ['artists' => $tartist->slug])); ?>"><?php echo e($tartist->name); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="item item-title">
                                    <span class="item-head"><?php echo e(L::_('Views')); ?>:</span>
                                    <span class="name"><?php echo e($manga->views); ?></span>
                                </div>
                                <div class="detail-toggle">
                                    <button type="button" class="btn btn-sm btn-light"><i
                                                class="fas fa-angle-down mr-2"></i>
                                    </button>
                                </div>
                                <div class="dt-rate" id="vote-info">
                                    <?php echo $__env->make('themes.mangareader.components.ajax.info-vote', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="social-in-box">
                        <div class="addthis_inline_share_toolbox"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/manga/detail.blade.php ENDPATH**/ ?>