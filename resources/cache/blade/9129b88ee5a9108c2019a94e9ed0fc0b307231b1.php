
<?php
include(ROOT_PATH . '/resources/views/includes/manga.php');
$manga->rating_score = floor(($manga->rating_score / 2) * 2) / 2;
if ($manga->rating_score <= 0) {
    $manga->rating_score = 5;
    $manga->total_rating = 1;
}
?>

<?php $__env->startSection('title', $metaConf['manga_title']); ?>
<?php $__env->startSection('description', $metaConf['manga_description'] ); ?>
<?php $__env->startSection('url', $manga_url); ?>
<?php $__env->startSection('image', $manga->cover); ?>

<?php echo $__env->make('ads.banner-ngang', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('ads.banner-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection("head-css"); ?>
    <link href="/kome/assets/css/manga.css" rel="stylesheet" type="text/css"/>
    <link  href="/kome/assets/css/rating.css" rel="stylesheet" type="text/css"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("body-js"); ?>
    <script type="text/javascript">
        var rating_point = "<?php echo e($manga->rating_score); ?>";
        var manga_id = <?php echo e($manga->id); ?>;
    </script>

    <script src="/kome/assets/js/manga.js" type="text/javascript"></script>
    <script src="/kome/assets/js/bookmarks.js" type="text/javascript"></script>

    <script src="/kome/assets/js/rmads.js" type="text/javascript"></script>


<?php $__env->stopSection(); ?>

<?php $__env->startSection("manga-breadcrumb"); ?>
    <nav class="manga-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb" itemscope=""
            itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope=""
                itemtype="http://schema.org/ListItem">
                <a title="Home" href="<?php echo e(url('home')); ?>" itemprop="item">
                    <span itemprop="name"><?php echo e(L::_("Home")); ?></span>
                </a>
                <meta itemprop="position" content="1">
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope=""
                itemtype="http://schema.org/ListItem">
                <a title="Manga List" href="<?php echo e(url("manga_list")); ?>" itemprop="item">
                    <span itemprop="name"><?php echo e(L::_("Manga")); ?></span>
                </a>
                <meta itemprop="position" content="2">
            </li>
            <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope=""
                itemtype="http://schema.org/ListItem">
                <a title="<?php echo e($manga->name); ?>"
                   href="<?php echo e($manga_url); ?>"
                   style="color: unset;" itemprop="item">
                    <span itemprop="name"><?php echo e($manga->name); ?> </span>
                </a>
                <meta itemprop="position" content="3">
            </li>
        </ol>
    </nav>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("detail-story"); ?>
    <div class="wrap-detail-story" itemscope="" itemtype="http://schema.org/ComicSeries">
        <div class="wrap-content-image" itemtype="https://schema.org/ImageObject">
            <img alt="<?php echo e($manga->name); ?>"
                 itemprop="image"
                 src="<?php echo e($manga->cover); ?>">
        </div>
        <div class="wrap-content-info">
            <h1 class="title" itemprop="name"><?php echo e($manga->name); ?></h1>
            <div class="list-info">
                <div class="info-row"><b class="info-title"><i class="ico-plus"></i> <?php echo e(L::_("Other Name")); ?></b>:
                    <span><?php echo e($manga->other_name ?? L::_("Updating")); ?></span>
                </div>
                <div class="info-row">
                    <b class="info-title"><i class="ico-paint-brush"></i> <?php echo e(L::_("Author")); ?></b> :
                    <?php if(!empty(($authors = get_manga_data('authors', $manga->id, [])))): ?>
                        <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(url('authors', ['authors' => $author->slug])); ?>"
                               rel="tag"><?php echo e($author->name); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <span> <?php echo e(L::_("Updating")); ?></span>
                    <?php endif; ?>
                </div>
                <div class="info-row">
                    <b class="info-title"><i class="ico-rss"></i> <?php echo e(L::_("Status")); ?></b> :
                    <span><?php echo e(status_name($manga->status)); ?><span></span></span>
                </div>
                <div class="info-row">
                    <b class="info-title"><i class="ico-eye"></i> <?php echo e(L::_("Views")); ?></b> :
                    <span><?php echo e($manga->views); ?></span>
                </div>
                <div class="row rating">
                    <div class="col-sm-6">
                        <div id="rating">
                            <?php for($i=5; $i >= 1; $i--): ?>
                                <input type="radio" id="star<?php echo e($i); ?>" name="rating" value="<?php echo e($i); ?>">
                                <label class="full" for="star<?php echo e($i); ?>" title="Awesome - <?php echo e($i); ?> stars"></label>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div itemscope="" itemtype="http://schema.org/Book">
                    <span itemprop="name" class="title-rating"> <?php echo e($manga->name); ?> </span>
                    <span itemprop="aggregateRating" itemscope=""
                          itemtype="https://schema.org/AggregateRating"> Rank:
                        <span itemprop="ratingValue"><?php echo e($manga->rating_score); ?></span>/5 -
                        <span itemprop="ratingCount"><?php echo e($manga->total_rating); ?></span> Evaluate.</span>
                    <meta property="worstRating" content="1">
                    <meta property="bestRating" content="5">
                </div>
                <div class="info-row list01 li03">
                    <?php $__currentLoopData = get_manga_data('genres', $manga->id, []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="genner-block" href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>"
                           title="<?php echo e($genre->name); ?>" rel="tag"><?php echo e($genre->name); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="info-row theodoitruyen">
                    <a href="#" action="bookmark"
                       class="centertextblock1 btn-top11 btn-primary btn_theodoitruyen shadow-none "
                       id="btn_theodoitruyen">
                        <i class="ico-bookmark"></i> <?php echo e(L::_("Bookmark")); ?></a>
                    <span class="total-bookmarks">
                        <b id="total-bookmark" total="<?php echo e($manga->total_bookmarks); ?>"><?php echo e($manga->total_bookmarks); ?></b> <?php echo e(L::_("User bookmarked")); ?></span>
                </div>
                <div class="info-row info-links" style="margin-top: 5px;">
                    <a class="centertextblock1 btn-top11 btn-primary shadow-none"
                       href="<?php echo e((isset($chapters) ? chapter_url($manga, $chapters[count($chapters)-1]) : '#')); ?>"
                       id="doctudau"
                       style="margin-right: 10px;"><?php echo e(L::_("Read First")); ?></a>
                    <a class="centertextblock1 btn-top11 btn-primary shadow-none"
                       href="<?php echo e((isset($chapters) ? chapter_url($manga, $chapters[0]) : '#')); ?>" id="docmoinhat"
                       style="margin-right: 5px;"><?php echo e(L::_("Read Last")); ?></a></div>
            </div>
        </div>
        <br class="clear"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("detail-content"); ?>
    <div class="wrap-detail-taiapp">
        <div class="detail-content" style="line-height: 30px;">
            <h3 class="h4 font-weight-bold medium-size">SUMMARY</h3>
            <p class="shortened"><?php echo e($manga->description); ?></p>
            <a href="#" class="morelink"><?php echo e(L::_("View more")); ?></a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="fed-part-case" id="main-content">
        <div class="wrap-content-part">
        <?php echo $__env->yieldContent("manga-breadcrumb"); ?>

        <!--  Detail Manga -->
        <?php echo $__env->yieldContent("detail-story"); ?>

        <!--  Description -->
            <?php echo $__env->yieldContent("detail-content"); ?>
        </div>

        <div class="wrap-content-part">

            <div class="header-content-part part-list-chap">
                <div class="title">
                    <span class="icon-title icon-2x ico-star-full"></span> <?php echo e(L::_("Chapters List")); ?> <span
                            id="reverse-order" class="more ico-swap"></span></div>
            </div>

            <div class="body-content-part" id="danhsachchuong">
                <ul class="lst-chapter" id="list-chapter">

                    <?php
                    $max_show = 10;
                    $num = 1;
                    ?>
                    <?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="chap-item <?php echo e(($num > $max_show ? 'less' : '')); ?>">
                            <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id])); ?>"
                               title=" <?php echo e($manga->name); ?> <?php echo e($chapter->name); ?>"
                               itemprop="url"> <?php echo e($chapter->name); ?> </a>
                            <span class="chapter-release-date"><?php echo e($chapter->views); ?> <?php echo e(L::_("views")); ?> - <?php echo e(date('Y-m-d', strtotime($chapter->last_update))); ?> </span>
                        </li>

                        <?php $num++;?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                </ul>

                <?php if(count($chapters) > $max_show): ?>
                    <a class="list-chap view-more" href="#"><?php echo e(L::_("View more")); ?> </a>
                <?php endif; ?>

            </div>

            <?php echo $__env->make("themes.kome.components.discus-comment", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.kome.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/themes/kome/pages/manga.blade.php ENDPATH**/ ?>