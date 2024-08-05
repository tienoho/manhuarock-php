<div id="header" class="header-reader">
    <div class="container">
        <div class="auto-div">
            <a href="<?php echo e(url('home')); ?>" id="logo" class="mr-0">
                <img src="/mangareader/images/logo.png" alt="logo hoitruyentranh">
                <div class="clearfix"></div>
            </a>
            <div class="hr-line"></div>
            <a title="<?php echo e($manga->name); ?>" href="<?php echo e(url('manga', ['m_id' => $manga->id, 'm_slug' => $manga->slug])); ?>"
                class="hr-manga">
                <h2 class="manga-name"><?php echo e($manga->name); ?></h2>
            </a>
            <div class="hr-navigation" style="display: none;">
                <div class="rt-item rt-read" style="display: none">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn">
                        <div class="d-block"><?php echo e(L::_('Chose server image')); ?></div>
                        <span class="name" id="reading-by"></span>
                        <span class="m-show">Vip</span><i class="fas fa-angle-down ml-2"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-model" aria-labelledby="ssc-list">
                        <a class="dropdown-item select-reading-by" data-value="chap" href="javascript:void(0)">
                            Vip</a>

                    </div>
                </div>
                <div id="reading-list" style="display: initial"></div>
                <div class="rt-item rt-navi">
                    <button type="button" class="btn btn-navi" onclick="prevChapterVolume()"><i
                            class="fas fa-arrow-left mr-2"></i>
                    </button>
                </div>
                <div class="rt-item rt-navi right">
                    <button type="button" class="btn btn-navi" onclick="nextChapterVolume()"><i
                            class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="float-right hr-right">
                <div class="hr-comment mr-2">
                    <a href="javascript:(0);" class="btn btn-sm hrr-btn">
                        <i class="far fa-comment-alt"></i>
                        <span class="number"><?php echo e((new \Models\Manga)->count_comment($manga->id)); ?></span>
                        <span class="hrr-name">Comments</span>
                    </a>
                    <div class="clearfix"></div>
                </div>
                <div class="hr-setting mr-2" style="display: none">
                    <a class="btn btn-sm hrr-btn"><i class="fas fa-cog"></i><span class="hrr-name"><?php echo e(L::_('Settings')); ?></span></a>
                    <div class="clearfix"></div>
                </div>
                <div class="hr-info mr-2">
                    <a title="<?php echo e($manga->name); ?>"
                        href="<?php echo e(url('manga', ['m_id' => $manga->id, 'm_slug' => $manga->slug])); ?>"
                        class="btn btn-sm hrr-btn"><i class="fas fa-info"></i><span class="hrr-name"><?php echo e(L::_('Manga
                            Detail')); ?></span></a>
                    <div class="clearfix"></div>
                </div>
                <div class="hr-fav" id="reading-list-info"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="ad-toggle"><i class="fas fa-expand-arrows-alt"></i></div>
    </div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/chapter/header.blade.php ENDPATH**/ ?>