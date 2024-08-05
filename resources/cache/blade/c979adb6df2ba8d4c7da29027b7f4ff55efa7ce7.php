<!DOCTYPE html>
<html lang="vi">
<!DOCTYPE html>
<html lang="vi">
<head>
    <title><?php echo $__env->yieldContent('title', 'Hội Truyện Tranh - Cổng Truyện Tranh Số Một VN'); ?></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" name="robots">
    <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=2" name="viewport">

    <meta content="vi" http-equiv="content-language">

    <meta content="<?php echo $__env->yieldContent('description', 'Hội Truyện Tranh, Đọc Truyện Vip Miễn Phí Cập Nhật Cực Nhanh'); ?>"
          name="description">

    <meta content="Manga, Manhua, Manhwa HoiMeTruyen, đọc truyện online, truyện tranh online, truyện tranh, truyện"
          name="keywords">

    <meta content="website" property="og:type">

    <meta content="<?php echo $__env->yieldContent('url', url()); ?>" property="og:url">
    <link href="<?php echo $__env->yieldContent('url', url()); ?>" rel="canonical">

    <meta content="<?php echo $__env->yieldContent('title', 'Hội Truyện Tranh - Cổng Truyện Tranh Số Một VN'); ?>" property="og:title">

    <meta content="<?php echo $__env->yieldContent('image', '/mangareader/images/share.png'); ?>" itemprop="image"/>
    <meta content="<?php echo $__env->yieldContent('image', '/mangareader/images/share.png'); ?>" name="thumbnail"/>
    <meta content="<?php echo $__env->yieldContent('image', '/mangareader/images/share.png'); ?>" property="og:image">

    <meta content="433270358518416" property="fb:app_id">

    <meta content="<?php echo $__env->yieldContent('description', 'Hội Truyện Tranh, Đọc Truyện Vip Miễn Phí Với Hơn 100.000 Chương Truyện Tranh Tiếng Việt'); ?>"
          property="og:description">

    <link href="/favicon.ico?v=0.1" rel="shortcut icon">
    <link href="/mangareader/images/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">
    <link href="/manifest.json?v2" rel="manifest">
    <link color="#5f25a6" href="/images/safari-pinned-tab.svg" rel="mask-icon">

    <meta content="#5f25a6" name="msapplication-TileColor">

    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//pagead2.googlesyndication.com">

    <!--<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">-->

    <link href="<?php echo e(asset('mangareader/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('mangareader/css/fontawesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('mangareader/css/styles.min.css')); ?>" rel="stylesheet">


    <script>
        var layout = 'read', isLoggedIn = <?php echo e(is_login() ? "true" : "false"); ?>;
    </script>

    <style>
        button, input, optgroup, select, textarea {
            font-family: 'PoppinsVN', sans-serif;
        }
    </style>


    <script type="application/ld+json">
        { 
            "@context": "http://schema.org", 
            "@type": "Person", 
            "name": "HoiMeTruyen", 
            "url": "<?php echo e(getenv("APP_URL")); ?>", 
            "sameAs": [
                "https://www.facebook.com/hoimetruyen.official"
            ] 
        }

    </script>

    <?php echo $__env->yieldContent('head'); ?>

</head>
<body class="page-reader">
<script>
    var uiMode = localStorage.getItem('uiMode');
    const body = document.body, btnMode = document.getElementById('toggle-mode'),
        sbBtnMode = document.getElementById('sb-toggle-mode');

    function activeUiMode() {
        if (uiMode === 'dark') {
            btnMode && btnMode.classList.add('active');
            sbBtnMode && sbBtnMode.classList.add('active');
            body.classList.add("darkmode");
        } else {
            btnMode && btnMode.classList.remove('active');
            sbBtnMode && sbBtnMode.classList.remove('active');
            body.classList.remove("darkmode");
        }
    }

    if (uiMode) {
        activeUiMode();
    } else {
        window.matchMedia('(prefers-color-scheme: dark)').matches ? uiMode = 'dark' : uiMode = 'light';
        activeUiMode();
    }
    [btnMode, sbBtnMode].forEach(item => {
        if (item) {
            item.addEventListener('click', function () {
                this.classList.contains('active') ? uiMode = 'light' : uiMode = 'dark';
                localStorage.setItem('uiMode', uiMode);
                activeUiMode();
            });
        }
    })
</script>
<?php echo $__env->yieldContent('content'); ?>
<?php echo $__env->make('themes.mangareader.components.modal-login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
    var recaptchaV3SiteKey = '6LcAhLscAAAAAMZLXweNWhQAF3YuYm1QRPNUZb18',
        recaptchaV2SiteKey = '6Lcig7scAAAAAGO9AdHg3j-mEcPEA7v9F488uiLq';
</script>

<script type="text/javascript" src="<?php echo e(asset('mangareader/js/jquery.min.js')); ?>"></script>
<script defer type="text/javascript" src="<?php echo e(asset('mangareader/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('mangareader/js/toastr.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('mangareader/js/js.cookie.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/mobile-detect@1.4.5/mobile-detect.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery.scrollto@2.1.3/jquery.scrollTo.min.js"></script>

<?php echo $__env->yieldContent('js-body'); ?>
<script src="<?php echo e(asset('mangareader/js/main.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('mangareader/js/comment.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('mangareader/js/read.js')); ?>" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        setTimeout(function () {
            getScript('https://cdn.jsdelivr.net/npm/jquery.scrollto@2.1.3/jquery.scrollTo.min.js');
        }, 1000);
    });

    var manga_url = '<?php echo e(url('manga', ['m_id' => $manga->id, 'm_slug' => $manga->slug])); ?>';

    window.onpopstate = function (e) {
        e.preventDefault();
        window.history.back();
    }

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

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'G-GG3N4DZD64');
</script>
</body>
</html><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/layouts/read.blade.php ENDPATH**/ ?>