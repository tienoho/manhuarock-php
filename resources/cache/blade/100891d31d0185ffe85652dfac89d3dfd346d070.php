

<?php
include(ROOT_PATH . '/resources/views/includes/manga.php');
$manga->rating_score = floor(($manga->rating_score / 2) * 2) / 2;
?>

<?php $__env->startSection('title', $metaConf['manga_title']); ?>
<?php $__env->startSection('description', $metaConf['manga_description'] ); ?>
<?php $__env->startSection('url', $manga_url); ?>
<?php $__env->startSection('image', $manga->cover); ?>

<?php echo $__env->make('ads.banner-ngang', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('ads.banner-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('schema'); ?>
    <script type="application/ld+json">
        <?php echo manga_schema($manga); ?>

    </script>

    <script type="application/ld+json">
        <?php echo chaps_schema($manga, $chapters); ?>

    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <script>
        var manga_id = <?php echo e($manga->id); ?>,
            manga_rating = <?php echo e($manga->rating_score); ?>

    </script>
    <div class="manga-content ">
        <script type="text/javascript" src="/manga18fx/js/js-jquery.cookie.js"></script>

        <?php echo $__env->make("themes.manga18fx.components.manga.profile", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="centernav">
            <div class="site-body">
                <?php if((new \Models\User)->hasPermission(['all', 'manga'])): ?>
                    <style>
                        .manage-menu .btn {
                            background: #191A19;
                            font-weight: 600;
                            color: #fff;
                        }

                    </style>
                    <div class="mb-4 manage-menu">
                        <a href="<?php echo e(url("admin.chapter-add", ['m_id' => $manga->id])); ?>" class="btn mr-2"> <i class="icofont-upload"></i> Thêm chương</a>
                        <a href="<?php echo e(url("admin.manga-edit", ['m_id' => $manga->id])); ?>" class="btn"> <i class="icofont-edit"></i> Sửa truyện</a>

                    </div>
                <?php endif; ?>

                <?php if (! empty(trim($__env->yieldContent('banner-ngang')))): ?>
                    <div class="mb-3">
                        <?php echo $__env->yieldContent('banner-ngang'); ?>
                    </div>
                <?php endif; ?>
                <div class="content-manga-left">
                    <div class="panel-story-description">
                        <h2 class="manga-panel-title "><i class="icofont-read-book"></i> <?php echo e(L::_("Summary")); ?>

                        </h2>
                        <div class="dsct">
                            <?php if(!empty(trim($manga->description))): ?>
                                <p><?php echo e($manga->description); ?></p>
                            <?php else: ?>
                                <p>
                                    <?php echo e($metaConf['manga_description']); ?>

                                </p>
                            <?php endif; ?>
                        </div>

                        <?php if (! empty(trim($__env->yieldContent('banner-ngang')))): ?>
                            <?php echo $__env->yieldContent('banner-ngang'); ?>
                        <?php endif; ?>
                    </div>


                    <div class="panel-manga-chapter " id="chapterlist">
                        <h2 class="manga-panel-title "><i
                                    class="icofont-flash"></i> <?php echo e(L::_("Latest Chapter Releases")); ?></h2>
                        <ul class="row-content-chapter ">
                            <?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="a-h ">
                                    <a class="chapter-name text-nowrap" data-chapter-id="<?php echo e($chapter->id); ?>"
                                       href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_id' => $chapter->id, 'c_slug' => $chapter->slug])); ?>"
                                       title="<?php echo e($manga->name); ?> <?php echo e($chapter->name); ?>"><?php echo e($chapter->name); ?></a>
                                    <span class="chapter-time text-nowrap"><?php echo e(time_convert($chapter->last_update)); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                        <div class="chapter-readmore  c-chapter-readmore">
                            <span style="display: inline;"><?php echo e(L::_("Show more")); ?> <i
                                        class="icofont-simple-down"></i></span>
                        </div>
                    </div>

                    <?php echo $__env->make('themes.manga18fx.components.comment', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="manga-tags ">
                        <h5>Tags:</h5>
                        <div class="tags_list">
                            <a href="#" rel="tag"><?php echo e($manga->name); ?></a>
                            <a href="#comic" rel="tag"><?php echo e($manga->name); ?> comic</a>
                            <a href="#raw" rel="tag"><?php echo e($manga->name); ?> raw</a>
                            <a href="#komik" rel="tag"><?php echo e($manga->name); ?> komik</a>
                            <a href="#scan" rel="tag"><?php echo e($manga->name); ?> Scan</a>
                            <a href="#all-chapters" rel="tag"><?php echo e($manga->name); ?> all chapters</a>
                            <a href="#webtoon" rel="tag"><?php echo e($manga->name); ?> webtoon</a>
                            <a href="#manhwa" rel="tag"><?php echo e($manga->name); ?> manhwa</a>
                        </div>
                    </div>
                    <div class="related-manga ">
                        <h4 class="manga-panel-title">
                            <i class="icofont-favourite"></i>
                            <?php echo e(L::_("YOU MAY ALSO LIKE")); ?>

                        </h4>

                        <div class="related-items">
                            <?php $__currentLoopData = (new \Models\Manga)->RelatedManga(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="item">
                                    <div class="rlbsx">
                                        <div class="thumb">
                                            <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                               title="<?php echo e($manga->name); ?>">
                                                <img data-src="<?php echo e($manga->cover); ?>"
                                                     src="<?php echo e($manga->cover); ?>" alt="<?php echo e($manga->name); ?>">
                                            </a>
                                        </div>
                                        <div class="bigor">
                                            <h5 class="tt">
                                                <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                                   title="<?php echo e($manga->name); ?>">
                                                    <?php echo e($manga->name); ?> </a>
                                            </h5>
                                            <div class="list-chapter">
                                                <?php $__currentLoopData = array_slice(get_manga_data('chapters', $manga->id, []),0,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="chapter-item">
                                                    <span class="chapter">
                                                        <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ])); ?>"
                                                           class="btn-link"
                                                           title="<?php echo e($manga->name); ?> <?php echo e($chapter->name); ?>"> <?php echo e($chapter->name); ?><?php if($chapter->name_extend): ?> - <?php echo e($chapter->name_extend); ?> <?php endif; ?></a>
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
                    </div>
                </div>
                <div class="sidebar">
                    <?php echo $__env->make("themes.manga18fx.components.popular-sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php if (! empty(trim($__env->yieldContent('banner-sidebar')))): ?>
                        <?php echo $__env->yieldContent('banner-sidebar'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-body'); ?>
    <style>
        .panel-manga-chapter ul li a.isread, .panel-manga-chapter ul li a:visited {
            color: #c1c1c1;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.chapter-readmore span').click(function () {
                $('.panel-manga-chapter ul').css('max-height', 'fit-content');
                $(this).css('display', 'none');
            });

            $(".chapter-name").each(function () {
                var chapid = $(this).data('chapter-id');

                if (chapid) {
                    if (localStorage.getItem('isread_' + chapid)) {
                        $(this).addClass('isread');
                    }
                }
            });

            if (!$.cookie('vote-' + manga_id)) {

                $(".my-rating").starRating({
                    initialRating: manga_rating,
                    totalStars: 5,
                    minRating: 1,
                    starShape: 'straight',
                    starSize: 25,
                    emptyColor: 'lightgray',
                    hoverColor: 'salmon',
                    activeColor: '#f9d932',
                    useGradient: false,
                    callback: function (currentRating, $el) {
                        $.cookie('vote-' + manga_id, '1', {expires: 60 * 24 * 60 * 60 * 1000});
                        $.ajax({
                            url: '/ajax/vote/submit',
                            type: 'POST',
                            data: {
                                'mark': currentRating * 2,
                                'mangaId': manga_id
                            },
                            success: function (data) {
                                $('.is_rate').css('display', 'block');
                            },
                            error: function (e) {
                                console.log(e.message);
                            }
                        });
                    }
                });
            } else {
                $(".my-rating").starRating({
                    initialRating: manga_rating,
                    totalStars: 5,
                    minRating: 1,
                    starShape: 'straight',
                    starSize: 25,
                    emptyColor: 'lightgray',
                    hoverColor: 'salmon',
                    activeColor: '#ffd900',
                    useGradient: false,
                    readOnly: true
                });
            }
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.manga18fx.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/manga18fx/pages/manga.blade.php ENDPATH**/ ?>