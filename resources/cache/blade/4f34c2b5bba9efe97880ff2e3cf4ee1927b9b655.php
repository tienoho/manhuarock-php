
<?php
include(ROOT_PATH . '/resources/views/includes/chapter.php');

$nextchap = null;
$pevchap = null;
$chapters = \Models\Chapter::ChapterListByID($manga->id);

foreach ($chapters as $key => $chap){
  if($chap->id === $chapter->id){
      if(isset($chapters[$key + 1])){
          $pevchap = $chapters[$key + 1];
      }

      if(isset($chapters[$key - 1])){
          $nextchap = $chapters[$key - 1];
      }
  }
}

?>

<?php $__env->startSection('title', $metaConf['chapter_title']); ?>
<?php $__env->startSection('description', $metaConf['chapter_description']); ?>

<?php $__env->startSection('url', $chapter_url); ?>
<?php $__env->startSection('image', $manga->cover); ?>

<?php echo $__env->make('ads.banner-ngang', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('ads.banner-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection("head-css"); ?>
    <link href="/kome/assets/css/chapter.css" rel="stylesheet" type="text/css"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("chapter-breadcrumb"); ?>
    <nav class="chapter-breadcrumb" aria-label="breadcrumb">
        <ol
            class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope=""
                itemtype="http://schema.org/ListItem"><a title="Home" href="<?php echo e(url("home")); ?>"
                                                         itemprop="item">
                    <span itemprop="name"><?php echo e(L::_("Home")); ?></span>
                </a>
                <meta itemprop="position" content="1">
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope=""
                itemtype="http://schema.org/ListItem">
                <a title="<?php echo e($manga->name); ?>" href="<?php echo e($manga_url); ?>" itemprop="item">
                    <span itemprop="name"><?php echo e($manga->name); ?></span>
                </a>
                <meta itemprop="position" content="2">
            </li>
            <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope=""
                itemtype="http://schema.org/ListItem">
                <a title="<?php echo e($manga->name); ?> <?php echo e($chapter->name); ?>"
                   href="<?php echo e($chapter_url); ?>" style="color: #ffffff94;" itemprop="item">
                    <span itemprop="name"><?php echo e($chapter->name); ?></span>
                </a>
                <meta itemprop="position" content="3">
            </li>
        </ol>
    </nav>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("wrap_header"); ?>
    <div class="wrap_header">
        <h1 class="tentruyen">
            <a title="<?php echo e($manga->name); ?>" href="<?php echo e($manga_url); ?>"><?php echo e($manga->name); ?></a>
            <a class="font-weight-normal" title="<?php echo e($manga->name); ?> <?php echo e($chapter->name); ?>"
               href="<?php echo e($chapter_url); ?>"><?php echo e($chapter->name); ?></a>
        </h1>
        <p><?php echo e(L::_("Updated On")); ?> : <?php echo e(date('Y-m-d', strtotime($chapter->last_update))); ?></p>
        <div style="margin:20px auto;">
            <button type="button" style="margin-right: 5px" class="btn btn-warning shadow-none" id="btnbaoloi"
                    data-toggle="modal" data-target="#baoloi">
                <i class="ico-warning"></i><?php echo e(L::_("Error Report")); ?>

            </button>
            <button type="button" class="btn btn-info shadow-none" id="btntheodoi" action="bookmark">
                <i class="ico-heart"></i><?php echo e(L::_("Bookmark")); ?>

            </button>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("wrap_navi"); ?>
    <div class="wrap_navi">
        <div class="flexRow mt-4 chapter_select">

            <a title="<?php echo e(($pevchap->name ?? '')); ?>" class="changeChap prev"
               href="<?php echo e(chapter_url($manga, $pevchap)); ?>"><span class="ico-angle-double-left"></span>
            </a>

            <div class="px-2 flex1 select-chapter">
                <select class="form-control chapter-select" onchange="window.location=this.value;">
                    <?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option data-id="<?php echo e($chap->id); ?>" value="<?php echo e(chapter_url($manga, $chap)); ?>"
                            <?php if($chap->id==$chapter->id): ?> selected="" <?php endif; ?>>
                        <?php echo e($chap->name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <a title="<?php echo e(($nextchap->name ?? '')); ?>" class="changeChap  next"
               href="<?php echo e(chapter_url($manga, $nextchap)); ?>"><span
                        class="ico-angle-double-right"></span></a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <script>
        var manga_id = <?php echo e($manga->id); ?>, chapter_id = <?php echo e($chapter->id); ?>, chapter_name = '<?php echo e($chapter->name); ?>'
    </script>

    <div class="fed-part-case" id="main-content">
        <main>
            <?php echo $__env->yieldContent("chapter-breadcrumb"); ?>

            <?php echo $__env->yieldContent("wrap_header"); ?>

            <?php echo $__env->yieldContent("wrap_navi"); ?>

            <div class="chapcontent" id="chapcontent">
                <div class="content-chap-image" id="content_chap">
                    <div class="fed-part-case">
                        <div id="lst_content" class="lst_image text-center">
                            <?php echo $__env->make("themes.kome.components.chapter.vertical-image-list", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <br class="clear"></div>
            </div>

            <?php echo $__env->yieldContent("wrap_navi"); ?>

            <?php echo $__env->make("themes.kome.components.discus-comment", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="modal fade" id="baoloi">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header"><h4 class="modal-title" id="myModalLabel"><?php echo e(L::_("Report Chapter")); ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" role="form">
                                <textarea class="txtbaoloi" cols="40" id="motabaoloi"
                                          placeholder="Write in the error description here ..."></textarea>
                            </form>
                            <p style="margin:20px 0;">
                                <button class="btn baoloibutton" style="width:150px;margin:0 auto;"><?php echo e(L::_("Send report")); ?><i
                                            class="fa ico-send"></i></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("body-js"); ?>
    <script src="/kome/assets/js/chapter.js" type="text/javascript"></script>
    <script src="/kome/assets/js/bookmarks.js" type="text/javascript"></script>
    <script src="/kome/assets/js/rmads.js" type="text/javascript"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.kome.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/themes/kome/pages/chapter.blade.php ENDPATH**/ ?>