
<?php $__env->startSection('title', getConf('meta')['home_title']); ?>
<?php $__env->startSection('description', getConf('meta')['home_description']); ?>
<?php $__env->startSection('url', url('home')); ?>

<?php echo $__env->make('ads.banner-ngang', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('ads.banner-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>

    <div class="manga-content">
        <div class="centernav">
            <div class="site-body">
                <?php if (! empty(trim($__env->yieldContent('banner-ngang')))): ?>
                    <div class="mb-3">
                        <?php echo $__env->yieldContent('banner-ngang'); ?>
                    </div>
                <?php endif; ?>

                <div class="bixbox" style="margin-bottom: 30px;">
                    <div class="releases">
                        <h2>
                            <i class="icofont-flash"></i>
                            <?php echo e(L::_("HOT MANGA UPDATES")); ?>

                        </h2>
                    </div>
                    <div class="listupd">
                        <?php $__currentLoopData = (new Models\Manga())->trending_manga(getConf('site')['total_pin']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="hot-item">
                                <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                   title="<?php echo e($manga->name); ?>">
                                    <div class="chapter-badges">
                                        <?php if($chapters = get_manga_data('chapters', $manga->id)): ?>
                                            <?php echo e($chapters[0]->name); ?>

                                        <?php endif; ?>
                                    </div>
                                    <img class="lazyload" data-src="<?php echo e($manga->cover); ?>"
                                         src="data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs="
                                         alt="<?php echo e($manga->name); ?>">
                                    <div class="caption">
                                        <h3><?php echo e($manga->name); ?></h3>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
                <div class="content-manga-left">
                    <div class="bixbox">

                        <div class="releases">
                            <h1>
                                <i class="icofont-flash"></i>
                                <?php echo e(L::_("LATEST MANGA UPDATES")); ?>

                            </h1>
                        </div>
                        <div class="listupd">
                            <?php $__currentLoopData = (new Models\Manga())->new_update($page, getConf('site')['newupdate_home']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="page-item">
                                    <div class="bsx-item">
                                        <div class="thumb-manga">
                                            <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                               title="<?php echo e($manga->name); ?>">
                                                <?php if($manga->adult): ?>
                                                    <div class="adult-badges">
                                                        18+
                                                    </div>
                                                <?php endif; ?>
                                                <img data-src="<?php echo e($manga->cover); ?>" class="lazyload"
                                                     src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                                     alt="<?php echo e($manga->name); ?>">
                                            </a>
                                        </div>
                                        <div class="bigor-manga">
                                            <h3 class="tt">
                                                <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                                   title="<?php echo e($manga->name); ?>">
                                                    <?php echo e($manga->name); ?> </a>
                                            </h3>
                                            <div class="item-rate">
                                                <div class="mmrate" data-rating="<?php echo e($manga->rating_score / 2); ?>"></div>
                                                <span><?php echo e(floor(($manga->rating_score / 2) * 2) / 2); ?></span>
                                            </div>
                                            <div class="list-chapter">
                                                <?php $__currentLoopData = array_slice(get_manga_data('chapters', $manga->id, []), 0 , 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="chapter-item wleft">
                                                    <span class="chapter">
                                                        <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ])); ?>"
                                                           class="btn-link"
                                                           title="<?php echo e($manga->name); ?> <?php echo e($chapter->name); ?>"> <?php echo e($chapter->name); ?> </a>
                                                    </span>
                                                        <?php if((strtotime('now') - strtotime($chapter->last_update)) < 86400): ?>
                                                            <span class="post-on">
                                                        <span class="c-new-tag">
                                                        <img style="width: 30px; height: 16px;"
                                                             src="/manhwa18cc/images/images-new.gif"
                                                             alt="<?php echo e($manga->name); ?> <?php echo e($chapter->name); ?>">
                                                        </span>
                                                    </span>
                                                        <?php else: ?>
                                                            <span class="post-on">
                                                        <span class="c-new-tag">
                                                        <?php echo e(time_convert($chapter->last_update)); ?>

                                                        </span>
                                                    </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php
                            $current_page = 1;
                            $num = 5
                            ?>
                            <div class="blog-pager" id="blog-pager">
                                <ul class="pagination">
                                    <li class="prev disabled">
                                        <span>«</span>
                                    </li>
                                    <?php for($i = 1 ; $i <= $num ; $i++): ?>
                                        <li class="<?php echo e($current_page === $i ? 'active' : ''); ?>">
                                            <a href="<?php echo e(url('manga_list', ['page' => $i])); ?>"
                                               data-page="<?php echo e($i); ?>"><?php echo e($i); ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="next">
                                        <a href="<?php echo e(url('manga_list', ['page' => 2])); ?>" data-page="2">»</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sidebar">
                    <?php if (! empty(trim($__env->yieldContent('banner-sidebar')))): ?>
                        <div class="mb-3">
                            <?php echo $__env->yieldContent('banner-sidebar'); ?>
                        </div>
                    <?php endif; ?>

                    <?php echo $__env->make("themes.manga18fx.components.history-sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php echo $__env->make("themes.manga18fx.components.popular-sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php if (! empty(trim($__env->yieldContent('banner-sidebar')))): ?>
                        <?php echo $__env->yieldContent('banner-sidebar'); ?>
                    <?php endif; ?>
                </div>

                <?php if (! empty(trim($__env->yieldContent('banner-ngang')))): ?>
                    <?php echo $__env->yieldContent('banner-ngang'); ?>
                <?php endif; ?>
            </div>
        </div>


    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-body'); ?>
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>

    <script type="text/javascript">
        $("img.lazyload").lazyload();
        $(document).ready(function () {
            $(".mmrate").starRating({
                totalStars: 5,
                starShape: 'straight',
                starSize: 20,
                emptyColor: 'lightgray',
                hoverColor: 'salmon',
                activeColor: '#ffd900',
                useGradient: false,
                readOnly: true
            });
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.manga18fx.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/manga18fx/pages/home.blade.php ENDPATH**/ ?>