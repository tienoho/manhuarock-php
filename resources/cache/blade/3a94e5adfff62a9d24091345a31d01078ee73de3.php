<div class="search-manga " style="display: none;">
    <div id="searchpc" class="header-search" ng-controller="livesearch">
        <form action="<?php echo e(url("search")); ?>" method="get">
            <input name="keyword" type="text" ng-model="search_query" ng-keyup="fetchData()" placeholder="Search..."
                   autocomplete="off">
            <button type="submit">
                <i class="icofont-search-1"></i>
            </button>
        </form>
        <div class="live-search-result live-pc-result" style="display: none;">
            <ul ng-if="searchData">
                <li ng-repeat="data in searchData">
                    <a class="" ng-click="readManga(data.id,data.slug)" ng-bind-html="data.name"
                       href="javascript:(0)"></a>
                </li>
            </ul>
            <div ng-if="loading" class="search-loading">
                <img src="/manga18fx/images/images-search-loading.gif" alt="loading...">
            </div>
        </div>
    </div>
</div>

<div class="header-manga pc-header ">
    <div class="header-top ">
        <div class="centernav">
            <div class="logo">
                <a  href="<?php echo e(url("home")); ?>">
                    <img src="/manhwa18cc/images/images-manhwa18.png">
                </a>
            </div>
            <div class="top-menu">
                <div class="left-menu">
                    <ul>
                        <li class="menu-item">
                            <a href="<?php echo e(url("home")); ?>" >
                                <i class="icofont-home"></i> <?php echo e(L::_("Home")); ?>

                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?php echo e(url("manga_list")); ?>"><?php echo e(L::_("All Manga")); ?></a>
                        </li>
                        <li class="menu-item">
                            <a id="bookmark-href" href="<?php echo e(url("user.reading-list")); ?>"><?php echo e(L::_("Bookmark")); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="right-menu">
                    <a class="open-search-main-menu search-ico" href="javascript:(0)">
                        <i class="icofont-search-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom ">
        <div class="centernav">
            <ul>
                <?php if((new \Models\User)->hasPermission(['all', 'manga'])): ?>
                    <li>
                        <a class="text-danger" href="<?php echo e(path_url('admin')); ?>"><i class="icofont-speed-meter"></i> <?php echo e(L::_("Admin")); ?></a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?php echo e(path_url("manga.history")); ?>"
                       class="text-danger"
                       title="<?php echo e(L::_("History")); ?>"><i class="icofont-history"></i> <?php echo e(L::_("History")); ?></a>
                </li>
                <li>
                    <a href="<?php echo e(url("completed")); ?>"
                       title="<?php echo e(L::_("Completed")); ?>"> <?php echo e(L::_("Completed")); ?></a>
                </li>
                <li>
                    <a href="<?php echo e(url("most-viewed")); ?>"
                       title="<?php echo e(L::_("Most Viewed")); ?>"> <?php echo e(L::_("Most Viewed")); ?></a>
                </li>
                <li class="dropdownmenu">
                    <a href="#" title="<?php echo e(L::_("Genres")); ?>">
                        <?php echo e(L::_("Genres")); ?> <i class="icofont-caret-right"></i>
                    </a>
                </li>
                <div class="sub-menu" style="display: none;">
                    <ul>
                        <?php $__currentLoopData = Models\Taxonomy::GetListGenres(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>"
                                   title="<?php echo e($genre->name); ?>"><?php echo e($genre->name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </ul>
            <?php echo $__env->make("themes.manga18fx.components.user-block", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>

<div class="header-manga mb-header ">
    <div class="top-header">
        <div class="menu-ico">
            <i class="icofont-navigation-menu open-menu"></i>
            <i class="icofont-close close-menu" style="display: none;"></i>
        </div>
        <div class="logo">
            <a href="<?php echo e(url("home")); ?>">
                <img src="/manhwa18cc/images/images-manhwa18.png">
            </a>
        </div>
        <div class="search-ico">
            <i class="icofont-search-1 open-search" style="display: block;"></i>
            <i class="icofont-close close-search" style="display: none;"></i>
        </div>
    </div>
    <div class="under-header">
        <div class="header-menu" style="display: none;">
            <ul>
                <li>
                    <a href="<?php echo e(url('home')); ?>" title="<?php echo e(L::_("Home")); ?>"><i
                                class="icofont-home"></i> <?php echo e(L::_("Home")); ?></a>
                </li>
                <li>
                    <a href="<?php echo e(url("manga_list")); ?>"
                       title="<?php echo e(L::_("All Manga")); ?>"><?php echo e(L::_("All Manga")); ?></a>
                </li>
                <li>
                    <a href="<?php echo e(url("user.reading-list")); ?>" title="<?php echo e(L::_("Bookmark")); ?>"><?php echo e(L::_("Bookmark")); ?></a>
                </li>

                <li>
                    <a class="text-danger" href="<?php echo e(url("manga.history")); ?>" title="<?php echo e(L::_("History")); ?>"><?php echo e(L::_("History")); ?></a>
                </li>
                <li class="dropdownmenumb">
                    <a href="#" title="Manga List - Genres: All">
                        <?php echo e(L::_("Genres")); ?> <i class="icofont-caret-right"></i>
                    </a>
                </li>
                <div class="sub-menumb" style="display: none;">
                    <ul>
                        <?php $__currentLoopData = Models\Taxonomy::GetListGenres(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>" title="<?php echo e($genre->name); ?>"><i
                                            class="icofont-caret-right"></i><?php echo e($genre->name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                </div>
                <li>
                    <a href="<?php echo e(url("completed")); ?>"
                       title="<?php echo e(L::_("Completed")); ?>"><?php echo e(L::_("Completed")); ?></a>
                </li>
            </ul>
            <?php echo $__env->make("themes.manga18fx.components.user-block", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/manga18fx/components/header.blade.php ENDPATH**/ ?>