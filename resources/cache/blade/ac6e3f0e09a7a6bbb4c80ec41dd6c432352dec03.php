<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auto Tool Manager</title>
    <!-- CSS files -->
    <link href="/tabler/css/tabler.min.css" rel="stylesheet">

    <style>
        body:not(.modal-open) {
            padding-right: 0 !important;
        }

        .modal.fade .modal-dialog {
            transition: fadeIn .3s ease-out;
            transform: none;
        }

        .btn-close:focus {
            outline: none !important;
            box-shadow: none;

        }
    </style>

    <script>
        var base_url = "<?php echo e(url("auto-tool")); ?>";
    </script>
    <!-- Libs JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body class="theme-light">
<div class="wrapper">
    <header class="navbar navbar-expand-md navbar-dark bg-primary d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href=".">
                    <img style="filter: brightness(0) invert(1);" src="/tabler/img/logo.svg" width="110" height="32"
                         alt="Tabler" class="navbar-brand-image">
                </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="" data-bs-toggle="tooltip"
                   data-bs-placement="bottom" data-bs-original-title="Enable dark mode">
                    <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"></path>
                    </svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="" data-bs-toggle="tooltip"
                   data-bs-placement="bottom" data-bs-original-title="Enable light mode">
                    <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"></path>
                    </svg>
                </a>
                <div class="nav-item dropdown d-none d-md-flex me-3">
                    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                       aria-label="Show notifications">
                        <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
                            <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                        </svg>
                        <span class="badge bg-red"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                        <div class="card">
                            <div class="card-body">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur
                                exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet
                                debitis et magni maxime necessitatibus ullam.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                       aria-label="Open user menu">
                        <span class="avatar avatar-sm">T</span>
                        <div class="d-none d-xl-block ps-2">
                            <div>Paweł Kuna</div>
                            <div class="mt-1 small text-muted">UI Designer</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="#" class="dropdown-item">Set status</a>
                        <a href="#" class="dropdown-item">Profile &amp; account</a>
                        <a href="#" class="dropdown-item">Feedback</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="navbar navbar-light">
                <div class="container-xl">
                    <ul class="navbar-nav">
                        <li class="nav-item <?php echo e(url() === url('auto-tool') ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(url('auto-tool')); ?>">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                           stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                           stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline
                                  points="5 12 3 12 12 3 21 12 19 12"></polyline><path
                                  d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path><path
                                  d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path></svg>
                    </span>
                                <span class="nav-link-title">
                      Dashboard
                    </span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(url() === url('auto-tool', ['campaign']) ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(url('auto-tool', ['campaign'])); ?>">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-spider" width="24"
                           height="24" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none"
                           stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M5 4v2l5 5"></path>
   <path d="M2.5 9.5l1.5 1.5h6"></path>
   <path d="M4 19v-2l6 -6"></path>
   <path d="M19 4v2l-5 5"></path>
   <path d="M21.5 9.5l-1.5 1.5h-6"></path>
   <path d="M20 19v-2l-6 -6"></path>
   <circle cx="12" cy="15" r="4"></circle>
   <circle cx="12" cy="9" r="2"></circle>
</svg>
                    </span>
                                <span class="nav-link-title">
                      Campaign
                    </span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(url() === url('auto-tool', ['cron-manage']) ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(url('auto-tool', ['cron-manage'])); ?>">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
   <circle cx="18" cy="18" r="4"></circle>
   <path d="M15 3v4"></path>
   <path d="M7 3v4"></path>
   <path d="M3 11h16"></path>
   <path d="M18 16.496v1.504l1 1"></path>
</svg>
                    </span>
                                <span class="nav-link-title">
                      Cron Manage
                    </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/docs/index.html">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/file-text -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                           stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                           stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path
                                  d="M14 3v4a1 1 0 0 0 1 1h4"></path><path
                                  d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path><line
                                  x1="9" y1="9" x2="10" y2="9"></line><line x1="9" y1="13" x2="15" y2="13"></line><line
                                  x1="9" y1="17" x2="15" y2="17"></line></svg>
                    </span>
                                <span class="nav-link-title">
                      Documentation
                    </span>
                            </a>
                        </li>
                    </ul>
                    <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                        <form action="." method="get" class="mb-0">
                            <div class="input-icon">
                    <span class="input-icon-addon">
                      <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                           stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                           stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle
                                  cx="10" cy="10" r="7"></circle><line x1="21" y1="21" x2="15" y2="15"></line></svg>
                    </span>
                                <input type="text" class="form-control" placeholder="Search…"
                                       aria-label="Search in website">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <?php echo $__env->yieldContent("content"); ?>
        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-lg-auto ms-lg-auto">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item"><a href="/docs/index.html"
                                                            class="link-secondary">Documentation</a>
                            </li>
                            <li class="list-inline-item"><a href="/license.html" class="link-secondary">License</a>
                            </li>
                            <li class="list-inline-item"><a href="https://github.com/tabler/tabler" target="_blank"
                                                            class="link-secondary" rel="noopener">Source code</a></li>
                            <li class="list-inline-item">
                                <a href="https://github.com/sponsors/codecalm" target="_blank" class="link-secondary"
                                   rel="noopener">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon text-pink icon-filled icon-inline" width="24" height="24"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"></path>
                                    </svg>
                                    Sponsor
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                Copyright © 2022
                                <a href="." class="link-secondary">NghiaHVA</a>.
                                All rights reserved.
                            </li>
                            <li class="list-inline-item">
                                <a href="/changelog.html" class="link-secondary" rel="noopener">
                                    v1.0.0-beta5
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<div id="modal-ajax-content">

</div>
<!-- Tabler Core -->
<script src="/tabler/js/tabler.min.js"></script>
<script src="/tabler/js/demo.min.js"></script>
<script src="/admin/js/auto-manga.js?v=<?php echo e(filemtime(ROOT_PATH . '/public/admin/js/auto-manga.js')); ?>"></script>

</body>
</html><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/autosite/layout.blade.php ENDPATH**/ ?>