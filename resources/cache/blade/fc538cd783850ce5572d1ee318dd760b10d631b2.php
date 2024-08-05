<!DOCTYPE html>
<html lang="vi">
<head>
    <title><?php echo $__env->yieldContent('title', 'Hội Truyện Tranh - Cổng Truyện Tranh Số Một VN'); ?></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" name="robots">
    <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=2" name="viewport">

    <meta content="vi" http-equiv="content-language">
    
    <meta content="<?php echo $__env->yieldContent('description', 'Hội Truyện Tranh, Đọc Truyện Vip Miễn Phí Cập Nhật Cực Nhanh'); ?>" name="description">

    <meta content="website" property="og:type">
    
    <meta content="<?php echo $__env->yieldContent('url', url()); ?>" property="og:url">
    <link href="<?php echo $__env->yieldContent('url', url()); ?>" rel="canonical">

    <meta content="<?php echo $__env->yieldContent('title', 'Hội Truyện Tranh - Cổng Truyện Tranh Số Một VN'); ?>" property="og:title">
    
    <meta content="<?php echo $__env->yieldContent('image', '/mangareader/images/share.png'); ?>" itemprop="image" />
    <meta content="<?php echo $__env->yieldContent('image', '/mangareader/images/share.png'); ?>" name="thumbnail" />
    <meta content="<?php echo $__env->yieldContent('image', '/mangareader/images/share.png'); ?>" property="og:image">
    
    <meta content="433270358518416" property="fb:app_id">

    <meta content="<?php echo $__env->yieldContent('description', 'Hội Truyện Tranh, Đọc Truyện Vip Miễn Phí Với Hơn 100.000 Chương Truyện Tranh Tiếng Việt'); ?>" property="og:description">
    
    <link href="/favicon.ico?v=0.1" rel="shortcut icon">
    <link href="/mangareader/images/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">
    <link href="/manifest.json?v2" rel="manifest">
    <link color="#5f25a6" href="/mangareader/images/safari-pinned-tab.svg" rel="mask-icon">
    
    <meta content="#5f25a6" name="msapplication-TileColor">

    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//pagead2.googlesyndication.com">

    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">

    <link href="<?php echo e(asset('mangareader/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('mangareader/css/fontawesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('mangareader/css/styles.min.css')); ?>" rel="stylesheet">

    <script>
        var layout = 'full', isLoggedIn = <?php echo e(is_login() ? "true" : "false"); ?>;
    </script>

     <style>

         
         .manga_list-sbs .mls-wrap .item .manga-detail .fd-list .fdl-item .chapter a:visited {
            color: #999;
         }
         
         body.darkmode .manga_list-sbs .mls-wrap .item .manga-detail .fd-list .fdl-item .chapter a:visited {
             color: #b5b5b5;
             
         }
     </style>
     
    <?php if (! empty(trim($__env->yieldContent('schema')))): ?>
        <?php echo $__env->yieldContent('schema'); ?>
    <?php else: ?>
        <script type="application/ld+json">
            <?php echo home_schema(); ?>

        </script>
    <?php endif; ?>

</head>
<body>

<?php echo $__env->make('themes.mangareader.components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div id="wrapper" <?php if (! empty(trim($__env->yieldContent('data-id')))): ?> data-manga-id="<?php echo $__env->yieldContent('data-id'); ?>" <?php endif; ?>>

    <?php echo $__env->make('themes.mangareader.components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('themes.mangareader.components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('themes.mangareader.components.modal-login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('modal'); ?>
</div>
<script>
    var recaptchaV3SiteKey = '6LcAhLscAAAAAMZLXweNWhQAF3YuYm1QRPNUZb18', recaptchaV2SiteKey = '6Lcig7scAAAAAGO9AdHg3j-mEcPEA7v9F488uiLq';
</script>

<script src="<?php echo e(asset('mangareader/js/jquery.min.js')); ?>" type="text/javascript"></script>
<script defer src="<?php echo e(asset('mangareader/js/bootstrap.bundle.min.js')); ?>" type="text/javascript" ></script>
<script src="<?php echo e(asset('mangareader/js/toastr.min.js')); ?>" type="text/javascript"></script>
<script defer src="<?php echo e(asset('mangareader/js/lazyload.min.js')); ?>"></script>

<?php echo $__env->yieldContent('js-body'); ?>
<script src="<?php echo e(asset('mangareader/js/main.js')); ?>" type="text/javascript"></script>

<script>

    $(document).ready(function () {

        lazyload();
        setTimeout(function () {
            
            if (isLoggedIn) {
                $.get('/ajax/notification/latest', function (res) {
                    $('.hr-notifications').html(res.html);
                })
            }
        }, 2000);
        

    });
    
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/sw.js?v=3');
        });
    }
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-GG3N4DZD64"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-GG3N4DZD64');
</script>
</body>
</html><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/layouts/full.blade.php ENDPATH**/ ?>