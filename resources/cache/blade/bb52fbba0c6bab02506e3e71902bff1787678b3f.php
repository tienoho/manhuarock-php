<div class="home-sub-header" id="sub-header">
    <div class="container">
        <div class="sh-left">
            <div class="float-left">
                <a class="sh-item" href="<?php echo e(url('random')); ?>"><i class="fas fa-glasses mr-2"></i><?php echo e(L::_('Read Random')); ?></a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="sh-right">
            <div class="float-left">
                <div class="sh-item mr-3">
                    <strong>Follow us :</strong>
                </div>
                <a class="sh-item mr-3" href="#" target="_blank"><i class="fab fa-reddit-alien mr-2"></i>Reddit</a>
                <a class="sh-item mr-3" href="#" target="_blank"><i class="fab fa-twitter mr-2"></i>Twitter</a>
                <a class="sh-item" href="#" target="_blank"><i class="fab fa-discord mr-2"></i>Discord</a>
                <div class="clearfix"></div>
            </div>
            <div class="spacing"></div>
            <div class="float-right">
                <a class="sh-item sb-uimode" id="toggle-mode"><i class="fas fa-moon mr-2"></i><span class="text-dm">Dark Mode</span><span class="text-lm">Light Mode</span></a>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
    </div>
</div>

<div class="<?php echo $__env->yieldContent('header-class'); ?>" id="header">
    <div class="container">
        <div id="mobile_menu">
            <i class="fa fa-bars"></i>
        </div>
        <div id="mobile_search">
            <i class="fa fa-search"></i>
        </div><a href="/" id="logo">

            <img alt="<?php echo e(getConf('meta')['site_name']); ?>" src="<?php echo e(getConf('mangareader')['logo']); ?>">

            <div class="clearfix"></div>
        </a>
        <div id="header_menu">
            <ul class="nav header_menu-list">
                <li class="nav-item">
                    <a href="<?php echo e(url('completed')); ?>" title="<?php echo e(L::_('Completed')); ?>"><?php echo e(L::_('Completed')); ?></a>
                </li>
                <li class="nav-item">
                    <a href="javascript:(0)" title="Types"><?php echo e(L::_('Types')); ?><i class="fas fa-angle-down ml-2"></i></a>
                    <div class="header_menu-sub" style="display: none;">
                        <ul class="sub-menu">
                            <?php $__currentLoopData = allComicType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type_id => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(url('manga.type', ['type' => $type_id])); ?>"><?php echo e($type); ?></a>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(url('filter')); ?>" title="<?php echo e(L::_("Filter")); ?>"><?php echo e(L::_("Filter")); ?></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div id="header_right" class="<?php echo e(is_login() ? 'user-logged' : ''); ?>">
            <div id="search">
                <div class="search-content">
                    <form action="<?php echo e(url('search')); ?>" autocomplete="off">
                        <a class="filter-icon" href="<?php echo e(url('filter')); ?>"><?php echo e(L::_('FILTER')); ?></a> <input class="form-control search-input" name="keyword" placeholder="Search manga..." type="text"> <button class="search-icon" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                    <div class="nav search-result-pop" id="search-suggest">
                        <div class="loading-relative" id="search-loading" style="min-height:60px;display: none;">
                            <div class="loading">
                                <div class="span1"></div>
                                <div class="span2"></div>
                                <div class="span3"></div>
                            </div>
                        </div>
                        <div class="result" style="display:none;"></div>
                    </div>
                </div>
            </div>
            <div id="login-state" style="float: left;">
                <?php echo $__env->make('themes.mangareader.components.ajax.login-state', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>
<script>
    var uiMode = localStorage.getItem('uiMode');
    const body = document.body
        , btnMode = document.getElementById('toggle-mode')
        , sbBtnMode = document.getElementById('sb-toggle-mode');
    var tableMode = [...document.querySelectorAll(".table")];

    function activeUiMode() {
        if (uiMode === 'dark') {
            btnMode && btnMode.classList.add('active');
            sbBtnMode && sbBtnMode.classList.add('active');
            body.classList.add("darkmode");
            tableMode && tableMode.map(item => {
                item.classList.add("table-dark");
            });
        } else {
            btnMode && btnMode.classList.remove('active');
            sbBtnMode && sbBtnMode.classList.remove('active');
            body.classList.remove("darkmode");

            tableMode && tableMode.map(item => {
                item.classList.remove("table-dark");
            });
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
            item.addEventListener('click', function() {
                this.classList.contains('active') ? uiMode = 'light' : uiMode = 'dark';
                localStorage.setItem('uiMode', uiMode);
                activeUiMode();
            });
        }
    })

</script>
<?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/header.blade.php ENDPATH**/ ?>