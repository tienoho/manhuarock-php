

<?php $__env->startSection('title', L::_("History")); ?>
<?php $__env->startSection('url', url('home')); ?>

<?php $__env->startSection('content'); ?>
    <style>
        #history_content {
            max-width: 1100px;
            width: 100%;
            margin: auto;
            padding: 10px 0 70px;
        }

        @media (max-width: 1115px) {
            #history_content {
                padding: 10px;
            }
        }

        .history-cover {
            width: 100%;
            object-fit: cover;
            max-height: 200px;
            height: 100%;
        }

        .history-name {
            font-size: 16px;
            color: #ffffff;
            font-weight: 600;
        }

        .header-content-part .title {
            text-align: -webkit-center;
        }

        .chapter a {
            padding: 5px 0 5px 0;
            color: #ffff;
            margin-right: 10px;
            display: inline-block;
        }

        .post-on {
            color: #6b6d81;
        }

        .chapter-item {
            padding: 6px 0;
        }

        .cover-container {
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }

        .continue {
            color: #fdd835;
        }
    </style>
    <div class="manga-content mt-3">
        <div class="fed-part-case" id="main-content">
            <div class="wrap-content-part list-manga">
                <div id="history_content">
                    <div class="header-content-part">
                        <h2 class="title"> <?php echo e(L::_('History')); ?></h2>
                    </div>


                    <div id="history_loading" class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection("body-js"); ?>
    <script src="/manga18fx/js/history.js" type="text/javascript"></script>

    <script type="text/javascript">
        var page = 1;

        $(document).ready(function () {
            getHistorys(page, 'history-page')
        });

        window.addEventListener('scroll', () => {
            console.log(window.scrollY) //scrolled from top
            console.log(window.innerHeight) //visible part of screen
            if (window.scrollY + window.innerHeight >=
                $("#history_content").prop("scrollHeight")) {
                page = page + 1;
                getHistorys(page, 'history-page')
            }
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.kome.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/kome/pages/history.blade.php ENDPATH**/ ?>