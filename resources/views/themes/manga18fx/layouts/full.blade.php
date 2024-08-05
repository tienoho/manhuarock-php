<?php
$siteConf = getConf('site');
$metaConf = getConf('meta');
?>
@include('ads.head')
@include('ads.body')
<!DOCTYPE html>
<html lang="vi">
<head>
    <title>@yield('title', $metaConf['home_title'])</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta content="vi" http-equiv="content-language">
    <meta content="@yield('description', $metaConf['home_description'])"  name="description">
    <meta content="website" property="og:type">
    <meta content="@yield('url', url())" property="og:url">
    <link href="@yield('url', url())" rel="canonical">
    <meta content="@yield('title', $metaConf['home_title'])" property="og:title">
    <meta content="@yield('image', '/mangareader/images/share.png')" itemprop="image"/>
    <meta content="@yield('image', '/mangareader/images/share.png')" name="thumbnail"/>
    <meta content="@yield('image', '/mangareader/images/share.png')" property="og:image">
    <meta content="433270358518416" property="fb:app_id">
    <meta content="@yield('description', $metaConf['home_description'])"property="og:description">
    <link href="/favicon.ico?v=0.1" rel="shortcut icon">
    <link href="/mangareader/images/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">
    <link href="/manifest.json?v2" rel="manifest">
    <link color="#5f25a6" href="/mangareader/images/safari-pinned-tab.svg" rel="mask-icon">
    <meta content="#5f25a6" name="msapplication-TileColor">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="/manga18fx/css/css-site_manhuarock.css" rel='stylesheet' type='text/css'/>
    <link href="/manga18fx/css/css-detail.min.css?v=0.0.11" rel='stylesheet' type='text/css'/>
    <script type="text/javascript" src="/manga18fx/js/js-jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <link href="/manga18fx/css/icofont-icofont.min.css" rel='stylesheet' type='text/css'/>
    <link href="/manga18fx/css/css-star-rating-svg.css" rel='stylesheet' type='text/css'/>
    <script>
        let isLoggedIn = {{ is_login() ? "true" : "false" }},
            slugConf = {
                manga: '{{ getConf('slug')['manga'] }}'
            };

    </script>
    <style>
        body {
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }        
        .panel-manga-chapter ul li a:visited {
            color: #6d6d6d40!important;
        }
        .avatar {
          vertical-align: middle;
          width: 50px;
          height: 50px;
          border-radius: 50%;
        }
        .sticky {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1;
            overflow: hidden;
            margin: 0% auto;
            left: 0;
            right: 0;
        }
    </style>
   
    @hasSection('schema')
        @yield('schema')
    @else
        <script type="application/ld+json">
            {!!home_schema()!!}
        </script>
    @endif

    @yield('head')

    @if(!empty($siteConf['analytics_id']))
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteConf['analytics_id'] }}"></script>
    
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ $siteConf['analytics_id'] }}');
    </script>

    @endif
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3208822458749559" crossorigin="anonymous"></script>
     
     <script>
    (function() {
    window.__fetch = window.__fetch || window.fetch;
    const script = document.createElement('script');
    script.src = 'https://api.trackpush.com/sdk/v3.js?pid=-L6FUdHqPYTSZGpbx9tJyQ&sw_uri=%2Fservice-worker.js';
    script.async = true;
    script.onload = function () {
        PushtimizeSDK.init({"block_until_allow":false});
        
    };
    document.head.append(script);
    })();
</script>

</head>

<body ng-app="myApp" class="bodymode">
    
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $siteConf['analytics_id'] }}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

@include('themes.manga18fx.components.header')

@yield('content')

@include('themes.manga18fx.components.footer')

<script type="text/javascript" src="/manhwa18cc/js/1.5.6-angular.min.js" defer></script>
<script type="text/javascript" src="/manhwa18cc/js/1.5.6-angular-sanitize.min.js" defer></script>
<script type="text/javascript" src="/manhwa18cc/js/js-main.js" defer></script>
<script type="text/javascript" src="/manhwa18cc/js/js-jquery.star-rating-svg.js"></script>

<script>
// document.addEventListener('DOMContentLoaded', function() {
//     // Lấy đối tượng <html>
//     var htmlElement = document.querySelector('html');

//     // Kiểm tra xem đã click hay chưa bằng cách kiểm tra trong Local Storage
//     var lastClickTime = localStorage.getItem('lastClickTime');
//     var currentTime = new Date().getTime();
//     if (!lastClickTime || (currentTime - lastClickTime > 2 * 60 * 60 * 1000)) {
//         // Nếu chưa click hoặc đã hơn 2 tiếng kể từ lần click cuối cùng, thực hiện click
//         htmlElement.addEventListener('click', function() {
//             // Lưu thời gian của lần click vào Local Storage
//             localStorage.setItem('lastClickTime', new Date().getTime());
//             // Mở tab mới với trang web khác
//             window.open('https://2ten.net', '_blank');
//         });
//     }
// });
</script>

@yield('js-body')

@yield('body')
</body>
<script>
var currentTab = window.self;
currentTab.focus();
</script>
<script>
   let nav = document.getElementById("navigation-chap-bar");
   let sticky = nav.offsetTop;
   window.onscroll = function() {sticker()};
   function sticker() {
      if (window.pageYOffset >= sticky) {
         nav.classList.add("sticky")
      } else {
         nav.classList.remove("sticky");
      }
   }
</script>
</html>