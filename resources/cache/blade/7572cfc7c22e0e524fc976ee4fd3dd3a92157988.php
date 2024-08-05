<div id="header" class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container" itemtype="http://schema.org/Organization" style="">
            <div class="navbar-brand mobile">
                <a action="open" id="bar">
                    <span class="ico-grid icon-2x"></span>
                </a>
            </div>
            <a class="NameSize pr-lg-5" href="<?php echo e(getConf('site')['site_url']); ?>" title="<?php echo e(getConf('meta')['home_title']); ?>"
               itemprop="url">
                <?php echo getConf("theme")['logo']; ?>

            </a>

            <div class="navbar-collapse" id="main-nav">
                <ul class="navbar-nav mr-auto" id="main-nav1">
                    <li class="search-mb">
                        <div id="search-mobile">
                            <div class="wrap-content-part mb-1">
                                <form action="<?php echo e(url("search")); ?>" method="get">
                                    <input aria-label="search" class="form-control mr-sm-2" id="txtSearchMB"
                                           name="keyword" placeholder="<?php echo e(L::_("Search")); ?>..."
                                           type="search"/>
                                    <button id="btnsearchMB" aria-label="search" type="submit">
                                        <span class="ico-search"></span></button>
                                </form>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a title="<?php echo e(L::_("All Manga")); ?>" class="nav-link" href="<?php echo e(url("manga_list")); ?>">
                            <?php echo e(L::_("All Manga")); ?> </a></li>
                    <li class="nav-item dropdown nav-theloai">
                        <a title="<?php echo e(L::_("Genres")); ?>" aria-expanded="false"
                           aria-haspopup="true" class="nav-link dropdown-toggle"
                           data-toggle="dropdown" href="#" id="wrap_lst_theloai"
                           role="button"><?php echo e(L::_("Genres")); ?></a>
                        <div aria-labelledby="navbarDropdown fade-down" class="dropdown-menu" id="list_theloai">
                            <?php $__currentLoopData = Models\Taxonomy::GetListGenres(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="dropdown-item" data-title="<?php echo e($genre->name); ?>" title="<?php echo e($genre->name); ?>"
                                   href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>" target="_self">
                                    <?php echo e($genre->name); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </li>
                </ul>
                <form action="<?php echo e(url("search")); ?>" class="form-inline my-2 my-lg-0" id="search_form" method="get" name="search_form">
                    <input aria-label="Search" class="form-control mr-sm-2" id="txtSearch" name="keyword"
                           placeholder="<?php echo e(L::_("Search")); ?>..." type="search"/>
                    <button aria-label="search" id="btnsearch" type="submit"><span class="ico-search"></span></button>
                </form>
                <div class="navbar-nav" id="rightmenu">
                    <?php if(!is_login()): ?>
                        <div class="nav-item dropdown">
                            <a class="link_dangnhap" href="<?php echo e(path_url("user.login")); ?>"> <i class="ico-user"></i>
                                <?php echo e(L::_("Login")); ?></a></div>
                    <?php else: ?>
                        <div class="nav-item dropdown">
                            <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle"
                               data-toggle="dropdown" href="#" id="navbarDropdown" role="button">
                                <img height="32" id="avatar" alt="<?php echo e(userget()->name); ?>" src="<?php echo e(userget()->avatar_url); ?>"
                                     width="32">
                            </a>
                            <div aria-labelledby="navbarDropdown" class="dropdown-menu dropshadow">
                                <?php if((new \Models\User)->hasPermission(['all', 'manga'])): ?>
                                    <a class="dropdown-item" href="<?php echo e(path_url('admin')); ?>"><?php echo e(L::_("Admin")); ?></a>
                                <?php endif; ?>
                                <a class="dropdown-item" href="<?php echo e(path_url("history")); ?>"><?php echo e(L::_("History")); ?></a>
                                <a class="dropdown-item"
                                   href="<?php echo e(path_url("user.reading-list")); ?>"><?php echo e(L::_("Bookmark")); ?></a>
                                <a class="dropdown-item" href="<?php echo e(path_url("logout")); ?>"><?php echo e(L::_("Logout")); ?></a></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</div>
<?php /**PATH F:\PHP\HMT\resources\views/themes/kome/components/header.blade.php ENDPATH**/ ?>