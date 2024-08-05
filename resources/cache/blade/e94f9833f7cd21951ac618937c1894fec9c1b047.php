<?php
$siteConf = getConf('site');
$metaConf = getConf('meta');
?>
<?php echo $__env->make('ads.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('ads.body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!DOCTYPE html>
<html lang="<?php echo e(\Config\Config::APP_LANG); ?>">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="HandheldFriendly" content="true"/>

    <title><?php echo $__env->yieldContent('title', $metaConf['home_title']); ?></title>

    <meta name=robots" content="index,follow">
    <meta name="distribution" content="web">

    <meta http-equiv="content-type" content="text/html;UTF-8">
    <meta http-equiv="content-language" content="<?php echo e(\Config\Config::APP_LANG); ?>">
    <meta http-equiv="content-security-policy" content="upgrade-insecure-requests">
    <meta name="description" content="<?php echo $__env->yieldContent('description', $metaConf['home_description']); ?>">

    <meta property="og:title" content="<?php echo $__env->yieldContent('title', $metaConf['home_title']); ?>"/>

    <meta property="og:site_name" data-page-subject="true" content="<?php echo e($metaConf['site_name']); ?>"/>
    <meta property="og:url" content="<?php echo $__env->yieldContent('url', url()); ?>"/>

    <meta property="og:description" name="description" content="<?php echo $__env->yieldContent('description', $metaConf['home_description']); ?>"/>

    <meta property="og:type" content="website"/>

    <meta property="fb:admins" content="100029967223133"/>
    <meta property="fb:pages" content="104519122365478"/>

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="<?php echo $__env->yieldContent('title', $metaConf['home_title']); ?>">
    <meta itemprop="description" content="<?php echo $__env->yieldContent('description', $metaConf['home_description']); ?>">
    <!-- Twitter Card data -->
    <meta name="twitter:card"
          content="<?php echo $__env->yieldContent("image", "https://i.imgur.com/sqCh4Yo.jpeg"); ?>">
    <!-- summary_large_image -->
    <meta name="twitter:site" content="<?php echo e($metaConf['site_name']); ?>">
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('title', $metaConf['home_title']); ?>"> <!-- Page title again -->
    <meta name="twitter:description" content="<?php echo $__env->yieldContent('description', $metaConf['home_description']); ?>">
    <!-- Page description less than 200 characters -->
    <meta name="twitter:creator" content="@nghia34522693"> <!-- @username  for the content creator / author. -->


    <meta property="og:image"
          content="<?php echo $__env->yieldContent("image", "https://i.imgur.com/sqCh4Yo.jpeg"); ?>"/>
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="630"/>

    <link rel="manifest" href="/manifest.webmanifest"/>

    <link rel="icon" type="image/png" sizes="192x192" href="/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="256x256" href="/icon-256x256.png">
    <link rel="icon" type="image/png" sizes="384x384" href="/icon-384x384.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/icon-512x512.png">

    <link href="/kome/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/kome/assets/css/main.css" rel="stylesheet" type="text/css"/>

    <?php echo $__env->yieldContent("head-css"); ?>

    <link href="/kome/assets/css/responsive.css" rel="stylesheet" type="text/css"/>

    <link rel="preconnect" href="https://fonts.gstatic.com/"/>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin/>
    <link rel="preload" as="font" href="/kome/assets/fonts/vncomic.ttf" crossorigin="anonymous"/>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap" rel="stylesheet">

    <link rel="alternate" type="application/rss+xml" title="<?php echo e($metaConf['site_name']); ?> » Feed"
          href="<?php echo e(url("rss")); ?>">

    <style>
        body {
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }
    </style>

    <link href="/kome/assets/css/fontcomic.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript">
        var isLoggedIn = <?php echo e(is_login() ? '1' : '0'); ?>;
        const csrf_token = "<?php echo e(csrf_token()); ?>";
        var siteURL = "<?php echo e($siteConf['site_url']); ?>";
        var lang = {
            Bookmark: "<?php echo e(L::_("Bookmark")); ?>",
            UnBookmark: "<?php echo e(L::_("UnBookmark")); ?>",
            MustBeLogin: "<?php echo e(L::_("You need to be logged in to use this function!")); ?>",
            See_more: "<?php echo e(L::_("View More")); ?>",
            See_less: "<?php echo e(L::_("Collapse")); ?>"
        };
    </script>
</head>
<body>

<?php echo $__env->make("themes.kome.components.header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make("themes.kome.components.navbar-breadcrumb", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent("content"); ?>

<script src="/kome/assets/js/jquery.min.js" type="text/javascript"></script>
<script src="/kome/assets/js/global.js" type="text/javascript"></script>
<script src="/kome/assets/js/bootstrap.js" type="text/javascript"></script>
<script src="/kome/assets/js/default.js" type="text/javascript"></script>
<script src="/kome/assets/js/scrolltotop.js" type="text/javascript"></script>
<script src="/kome/assets/js/jquery.lazyload.min.js" type="text/javascript"></script>

<?php echo $__env->yieldContent("body-js"); ?>

<script type="text/javascript">jQuery(window).bind("load", function () {
        jQuery('.fed-lazy').lazy({
            effect: "fadeIn",
        });
    });


</script>
<div id="footer" class="footer-dark">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6 item text mb-3"><h3>ABOUT US</h3>
                    <p class="mt-3">All the readmanwha on this site are the property of the publisher. We are just
                        trying to translate them into other languages so that you can more easily track them. Do not try
                        to make a profit from these. If you like any of the comics you get here, consider buying them
                        from the publisher, if available.</p></div>
                <div class="col-6 col-sm-6 col-md-3 item"><h3>MENU</h3>
                    <ul>
                        <li class="mt-3"><a href="/">Home Page</a></li>
                        <li class="mt-3"><a href="<?php echo e(url("sitemap.xml")); ?>">Sitemap</a></li>
                        <li class="mt-3"><a href="<?php echo e(url("rss")); ?>">RSS</a></li>
                    </ul>
                </div>
                <div class="col-6 col-sm-6 col-md-3 item"><h3>HELPFUL LINKS</h3>
                    <ul>
                        <li class="mt-3"><a href="<?php echo e(url("terms")); ?>">Terms of service</a></li>
                        <li class="mt-3"><a href="#">Contact Us</a></li>
                        <li class="mt-3"><a href="#">DMCA</a></li>
                    </ul>
                </div>
                <div class="col item social"><a href="#">
                        <span class="ico-logo-facebook"></span>
                    </a>
                    <a href="#">
                        <span class="ico-twitter"></span>
                    </a>
                    <a href="#">
                        <span class="ico-snap-chat"></span>
                    </a>
                    <a href="#">
                        <span class="ico-instagram"></span>
                    </a></div>
            </div>
            <p class="copyright"><?php echo e($metaConf['site_name']); ?> © 2019 - <?php echo e(date('Y')); ?></p></div>
    </footer>
</div>

<script>
    if ('serviceWorker' in navigator) {
        // Register a service worker hosted at the root of the
        // site using the default scope.
        navigator.serviceWorker.register('/sw.js').then(function (registration) {
            console.log('Service worker registration succeeded:', registration);
        }, /*catch*/ function (error) {
            console.log('Service worker registration failed:', error);
        });
    } else {
        console.log('Service workers are not supported.');
    }
</script>
</body>
</html><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/kome/layouts/full.blade.php ENDPATH**/ ?>