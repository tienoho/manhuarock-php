<?php
$siteConf = getConf('site');
$metaConf = getConf('meta');


?>

@include('ads.head')
@include('ads.body')


        <!DOCTYPE html>
<html lang="vi" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#262626">
    <meta name="a.validate.01" content="61de175a6bd403818b606cb2c247579c099e"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://hentaiz.cc/wp-content/themes/ztube/assets/css/ui.css">
    <link rel="stylesheet" href="https://hentaiz.cc/wp-content/themes/ztube/assets/css/style.css?ver=1.1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/latest/js.cookie.min.js"></script>
    <link rel="icon" href="https://hentaiz.cc/wp-content/themes/ztube/assets/images/icon.png" type="image/png">
    <link rel="apple-touch-icon" href="https://hentaiz.cc/wp-content/themes/ztube/assets/images/icon.png"
          type="image/png">
    <script>
        const ajax = async formData => {
            try {
                const res = await fetch(
                    'https://hentaiz.cc/wp-admin/admin-ajax.php',
                    {method: 'POST', credentials: 'same-origin', body: formData}
                );
                const {success, data} = await res.json();
                if (!success) triggerAlert(data.error);
                return data;
            } catch (e) {
                console.log(e.message);
            }
        }
    </script>

    <link rel="manifest" href="/superpwa-manifest.json">
    <link rel="prefetch" href="/superpwa-manifest.json">
    <meta name="theme-color" content="#302a2a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-title" content="HentaiZ">
    <meta name="application-name" content="HentaiZ">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" sizes="192x192"
          href="https://hentaiz.cc/wp-content/themes/ztube/assets/images/icons/192.png">
    <link rel="apple-touch-icon" sizes="192x192"
          href="https://hentaiz.cc/wp-content/themes/ztube/assets/images/icons/192.png">
    <link rel="apple-touch-icon" sizes="512x512"
          href="https://hentaiz.cc/wp-content/themes/ztube/assets/images/icons/512.png">
    <link rel="apple-touch-icon" sizes="512x512"
          href="https://hentaiz.cc/wp-content/themes/ztube/assets/images/icons/512.png">
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_1136x640.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_640x1136.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_2688x1242.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_1792x828.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_1125x2436.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_828x1792.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_2436x1125.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_1242x2208.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_2208x1242.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_1334x750.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_750x1334.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_2732x2048.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_2048x2732.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_2388x1668.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_1668x2388.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_2224x1668.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_1242x2688.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_1668x2224.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_1536x2048.png"/>
    <link rel="apple-touch-startup-image"
          media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
          href="https://hentaiz.cc/wp-content/uploads/superpwa-splashIcons/super_splash_screens/icon_2048x1536.png"/>
    <title>Phim Hentai Vietsub - Xem Anime Sex Hay 18+ Không Che</title>
    <meta name="description"
          content="Trang web xem phim sex anime hentai vietsub miễn phí chất lượng cao lớn nhất VN. Tải phim hoạt hình người lớn 18+ Full HD Không Che/Uncensored cực nét"/>
    <meta name="robots" content="follow, index"/>
    <link rel="canonical" href="https://hentaiz.cc/">
    <link rel="next" href="https://hentaiz.cc/page/2/">
    <meta property="og:locale" content="vi_VN">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Phim Anime Mèo Đen">
    <meta property="og:description"
          content="Trang web xem phim sex anime hentai vietsub miễn phí chất lượng cao lớn nhất VN. Tải phim hoạt hình người lớn 18+ Full HD Không Che/Uncensored cực nét">
    <meta property="og:url" content="https://hentaiz.cc/">
    <meta property="og:site_name" content="Phim Hentai Vietsub - Xem Anime Sex Hay 18+ Không che">
    <meta property="fb:app_id" content="2120161908028261">
    <meta property="og:image" content="https://hentaiz.cc/wp-content/uploads/2021/04/512.png">
    <meta property="og:image:secure_url" content="https://hentaiz.cc/wp-content/uploads/2021/04/512.png">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:image:alt" content="mèo đen">
    <meta property="og:image:type" content="image/png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Phim Anime Mèo Đen">
    <meta name="twitter:description"
          content="Trang web xem phim sex anime hentai vietsub miễn phí chất lượng cao lớn nhất VN. Tải phim hoạt hình người lớn 18+ Full HD Không Che/Uncensored cực nét">
    <meta name="twitter:image" content="https://hentaiz.cc/wp-content/uploads/2021/04/512.png">
    <script type="application/ld+json" class="rank-math-schema-pro">
        {"@context":"https://schema.org","@graph":[{"@type":"Person","@id":"https://hentaiz.cc/#person","name":"adminx","image":{"@type":"ImageObject","@id":"https://hentaiz.cc/#logo","url":"https://hentaiz.cc/wp-content/uploads/2021/04/512.png","caption":"adminx","inLanguage":"vi","width":"512","height":"512"}},{"@type":"WebSite","@id":"https://hentaiz.cc/#website","url":"https://hentaiz.cc","name":"adminx","publisher":{"@id":"https://hentaiz.cc/#person"},"inLanguage":"vi","potentialAction":{"@type":"SearchAction","target":"https://hentaiz.cc/?s={search_term_string}","query-input":"required name=search_term_string"}},{"@type":"CollectionPage","@id":"https://hentaiz.cc/#webpage","url":"https://hentaiz.cc/","name":"Phim Hentai Vietsub - Xem Anime Sex Hay 18+ Kh\u00f4ng Che","about":{"@id":"https://hentaiz.cc/#person"},"isPartOf":{"@id":"https://hentaiz.cc/#website"},"inLanguage":"vi"}]}




    </script>
    <meta name="google-site-verification" content="iQyfrMxxhwdoEnEIIvsK70LQJiqyQtE6QIXIQomixsM">
    <link rel='dns-prefetch' href='//s.w.org'>
    <link rel="alternate" type="application/rss+xml"
          title="Dòng thông tin Phim Hentai Vietsub - Xem Anime Sex Hay 18+ Không che &raquo;"
          href="https://hentaiz.cc/feed/">
    <link rel="alternate" type="application/rss+xml"
          title="Dòng phản hồi Phim Hentai Vietsub - Xem Anime Sex Hay 18+ Không che &raquo;"
          href="https://hentaiz.cc/comments/feed/">
    <link rel='stylesheet' id='wp-block-library-css'
          href='https://hentaiz.cc/wp-includes/css/dist/block-library/style.min.css?ver=5.9.3' media='all'>


    <link rel="https://api.w.org/" href="https://hentaiz.cc/wp-json/">
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://hentaiz.cc/xmlrpc.php?rsd">
    <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://hentaiz.cc/wp-includes/wlwmanifest.xml">

    <link rel="preload" href="/wp-includes/css/dist/block-library/style.min.css?ver=5.9.3" as="style">
<script data-cfasync="false" async type="text/javascript" src="//atriblethetch.com/rA5qGFD9sOzlW1pet/63016"></script>
</head>
<body class="home blog bg-dark text-light font-weight-light">

@include("themes.hentaiz.components.header")


@yield("content")

@include("themes.hentaiz.components.footer")

<script defer src="https://hentaiz.cc/wp-content/themes/ztube/assets/js/ui.js"></script>
<script defer src="https://hentaiz.cc/wp-content/themes/ztube/assets/js/script.js"></script>
<script>
(function() {
    var script = document.createElement('script');
    script.src = 'https://api.trackpush.com/sdk/inpage/v1.js?pid=-L6FUdHqPYTSZGpbx9tJyQ';
    script.async = true;
    script.onload = function () {
        InPagePushSDK.init({"content_type":"all","time_to_show":"onload","delay_show":0,"max_ads":3,"max_showing":2,"max_showing_mobile":1,"ads_interval":5,"closeable":"1","position":"top","mobile_position":"top","align":"right"});
        
    };
    document.head.append(script);
})();
</script>
</body>
</html>

