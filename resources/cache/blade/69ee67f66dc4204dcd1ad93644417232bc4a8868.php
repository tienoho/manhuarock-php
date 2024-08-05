<?php
$siteConf = getConf('site');
$metaConf = getConf('meta');


?>
<?php echo $__env->make('ads.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('ads.body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title><?php echo $__env->yieldContent('title', $metaConf['home_title']); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta content="vi" http-equiv="content-language">

    <meta content="<?php echo $__env->yieldContent('description', $metaConf['home_description']); ?>"
          name="description">


    <meta content="website" property="og:type">

    <meta content="<?php echo $__env->yieldContent('url', url()); ?>" property="og:url">
    <link href="<?php echo $__env->yieldContent('url', url()); ?>" rel="canonical">

    <meta content="<?php echo $__env->yieldContent('title', $metaConf['home_title']); ?>" property="og:title">

    <meta content="<?php echo $__env->yieldContent('image', '/mangareader/images/share.png'); ?>" itemprop="image"/>
    <meta content="<?php echo $__env->yieldContent('image', '/mangareader/images/share.png'); ?>" name="thumbnail"/>
    <meta content="<?php echo $__env->yieldContent('image', '/mangareader/images/share.png'); ?>" property="og:image">

    <meta content="433270358518416" property="fb:app_id">

    <meta content="<?php echo $__env->yieldContent('description', $metaConf['home_description']); ?>"
          property="og:description">

    <link href="/favicon.ico?v=0.1" rel="shortcut icon">
    <link href="/mangareader/images/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">
    <link href="/manifest.json?v2" rel="manifest">
    <link color="#5f25a6" href="/mangareader/images/safari-pinned-tab.svg" rel="mask-icon">

    <meta content="#5f25a6" name="msapplication-TileColor">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="/manga18fx/css/css-site_manhuarock.css" rel='stylesheet' type='text/css'/>
    <link href="/manga18fx/css/css-detail_manhuarock.css" rel='stylesheet' type='text/css'/>

    <script type="text/javascript" src="/manga18fx/js/js-jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

    <link href="/manga18fx/css/icofont-icofont.min.css" rel='stylesheet' type='text/css'/>
    <link href="/manga18fx/css/css-star-rating-svg.css" rel='stylesheet' type='text/css'/>

    <script>
        let isLoggedIn = <?php echo e(is_login() ? "true" : "false"); ?>,
            slugConf = {
                manga: '<?php echo e(getConf('slug')['manga']); ?>'
            };

    </script>

    <style>
        body {
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }
        
        .panel-manga-chapter ul li a:visited {
            color: #6d6d6d40!important;
        }
    </style>
   
    <?php if (! empty(trim($__env->yieldContent('schema')))): ?>
        <?php echo $__env->yieldContent('schema'); ?>
    <?php else: ?>
        <script type="application/ld+json">
            <?php echo home_schema(); ?>

        </script>
    <?php endif; ?>

    <?php echo $__env->yieldContent('head'); ?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-KYNFFKSVGQ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-KYNFFKSVGQ');
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2726140056865606"
     crossorigin="anonymous"></script>
</head>
<body ng-app="myApp" class="bodymode">

<?php echo $__env->make('themes.manga18fx.components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('themes.manga18fx.components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<script type="text/javascript" src="/manhwa18cc/js/1.5.6-angular.min.js" defer></script>
<script type="text/javascript" src="/manhwa18cc/js/1.5.6-angular-sanitize.min.js" defer></script>
<script type="text/javascript" src="/manhwa18cc/js/js-main.js" defer></script>
<script type="text/javascript" src="/manhwa18cc/js/js-jquery.star-rating-svg.js"></script>
<?php echo $__env->yieldContent('js-body'); ?>

<?php if(!empty($siteConf['analytics_id'])): ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($siteConf['analytics_id']); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '<?php echo e($siteConf['analytics_id']); ?>');
    </script>
<?php endif; ?>

<?php echo $__env->yieldContent('body'); ?>
</body>
<script>
var currentTab = window.self;
currentTab.focus();
</script>
</html><?php /**PATH /www/wwwroot/mangarock.top/resources/views/themes/manga18fx/layouts/full.blade.php ENDPATH**/ ?>