<div id="main-wrapper" class="page-layout page-read">
    <div class="container">
        <div class="container-reader-chapter" id="vertical-content">
            <div class="iv-card loaded" style="display: none;height: 100vh">
                <div class="card-loading ">
                    <div class="c-l-area">
                        <div class="paper-loading"></div>
                        <p class="mb-0">Loading...</p></div>
                </div>
            </div>

    <div class="ads-content">
    <!-- Banner ngang -->
    <ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9778931209315986"
     data-ad-slot="6419846843"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    </div>
            <?php $__currentLoopData = $chapter_data->content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="iv-card <?php echo e((strpos($image, 'shuffled') !== false) ? "shuffled" : ''); ?>"
                 data-url="<?php echo e($image); ?>"
                 data-number="<?php echo e($key); ?>">
                <div class="card-loading ">
                    <div class="c-l-area">
                        <div class="paper-loading"></div>
                        <p class="mb-0">Loading...</p></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="ads-content">
    <!-- Banner ngang -->
    <ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9778931209315986"
     data-ad-slot="6419846843"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    </div>
    
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="mr-tools mrt-bottom">
    <div class="container">
        <div class="read_tool">
            <div class="float-left" id="ver-prev-cv">
                <div class="rt-item">
                    <button type="button" class="btn btn-navi" onclick="prevChapterVolume();"><i
                                class="fas fa-arrow-left mr-2"></i>Prev Chapter
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="float-right" id="ver-next-cv">
                <div class="rt-item">
                    <button type="button" class="btn btn-navi" onclick="nextChapterVolume();"> Next Chapter<i class="fas fa-arrow-right ml-2"></i></button>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="dt-rate" id="vote-info">

</div><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/components/chapter/vertical-image-list.blade.php ENDPATH**/ ?>