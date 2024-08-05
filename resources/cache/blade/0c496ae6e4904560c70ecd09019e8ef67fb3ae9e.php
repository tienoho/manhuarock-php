<?php
include(ROOT_PATH . '/resources/views/includes/chapter.php');

$chapters = \Models\Chapter::ChapterListByID($manga->id);
?>

<?php $__env->startSection('title', $metaConf['chapter_title']); ?>
<?php $__env->startSection('description', $metaConf['chapter_description']); ?>

<?php $__env->startSection('url', $chapter_url); ?>
<?php $__env->startSection('image', $manga->cover); ?>

<?php echo $__env->make('ads.banner-ngang', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('ads.banner-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
    <script>
        var manga_id = <?php echo e($manga->id); ?>, chapter_id = <?php echo e($chapter->id); ?>, chapter_name = '<?php echo e($chapter->name); ?>'
    </script>
    <div class="manga-content wleft">
        <div class="readmanga">
            <div class="centernav">
                <?php echo $__env->make('themes.manga18fx.components.chapter.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="manga-body">
                    <div class="read-manga">
                        <?php if (! empty(trim($__env->yieldContent('banner-ngang')))): ?>
                            <div class="mt-3 mb-3">
                                <?php echo $__env->yieldContent('banner-ngang'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="chapchange">
                            <h1 class="tcenter"><?php echo e($manga->name); ?> - <?php echo e($chapter->name); ?></h1>
                            <?php echo $__env->make("themes.manga18fx.components.chapter.chapter-source", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo $__env->make("themes.manga18fx.components.chapter.navigation", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="text-center mt-3">
                            <button id="error_report" class="btn btn-warning" type="button"> <?php echo e(L::_("Error Report")); ?> </button>
                        </div>
                        <div class="read-content tcenter">
                            <div class="waiting" style="margin:auto; max-width: 800px;padding: 70px 0; text-align: -webkit-center; background-color: #ffffff; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;">
                                <?php echo e(L::_("PLEASE WAIT CONTENT ...")); ?>

                            </div>
                        </div>
                        <div class="chapchange">
                            <?php echo $__env->make("themes.manga18fx.components.chapter.navigation-footer", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>

                        <?php if (! empty(trim($__env->yieldContent('banner-ngang')))): ?>
                            <div class="mt-3">
                                <?php echo $__env->yieldContent('banner-ngang'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="mt-3"></div>
                        <?php echo $__env->make('themes.manga18fx.components.comment', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="mt-5"></div>

                        <div class="related-manga wleft">
                            <h4 class="manga-panel-title"><i class="icofont-star-shape"></i> <?php echo e(L::_("You May Also Like")); ?></h4>
                            <div class="related-items">
                                <?php $__currentLoopData = (new \Models\Manga)->RelatedManga(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="item">
                                        <div class="rlbsx">
                                            <div class="thumb">
                                                <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>" title="<?php echo e($manga->name); ?>">
                                                    <img data-src="<?php echo e($manga->cover); ?>" src="<?php echo e($manga->cover); ?>" alt="<?php echo e($manga->name); ?>">
                                                </a>
                                            </div>
                                            <div class="bigor">
                                                <h5 class="tt">
                                                    <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                                                       title="<?php echo e($manga->name); ?>">
                                                        <?php echo e($manga->name); ?> </a>
                                                </h5>
                                                <div class="list-chapter">
                                                    <?php $__currentLoopData = array_slice(get_manga_data('chapters', $manga->id, []),0,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="chapter-item">
                                                    <span class="chapter">
                                                        <a href="<?php echo e(url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ])); ?>"
                                                           class="btn-link"
                                                           title="<?php echo e($manga->name); ?> <?php echo e($chapter->name); ?>"> <?php echo e($chapter->name); ?> </a>
                                                    </span>
                                                            <span class="post-on"><?php echo e(time_convert($chapter->last_update)); ?> </span>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
            $(document).ready(function () {
                $('.navi-change-chapter').change(function () {
                    const url = $(this).find(':selected').attr('data-c');
                    window.location.replace(url);
                });
                const current_selected = $('.navi-change-chapter option:selected');
                const next_chap = current_selected.prev().attr('data-c');
                const prev_chap = current_selected.next().attr('data-c');

                $(".navi-change-chapter-btn-next").attr("href", next_chap)
                $(".navi-change-chapter-btn-prev").attr("href", prev_chap)

                if (!next_chap) {
                    $(".navi-change-chapter-btn-next").on('click', function () {
                        alert("Hết chap òi baby")
                    })
                }
                $.get('/ajax/image/list/chap/' + chapter_id + '?mode=vertical&quality=high', function (res) {
                    if (res.status === true) {
                        $(".read-content").html(res.html)
                    }
                })
            });
    </script>

    <script>
        const Lang = {
            enter_error: "<?php echo e(L::_("Please enter your error")); ?>",
            logged_report: "<?php echo e(L::_("An error has been reported, we will fix it quickly")); ?>"
        }

        $(document).ready(function () {
            if (typeof (Storage) !== 'undefined') {
                let manga_history = localStorage.getItem('manga_history');
                let isread = 'isread_' + chapter_id;
                if (!localStorage.getItem(isread)) {
                    localStorage.setItem(isread, 1);
                }
                if (!manga_history) {
                    manga_history = [];
                } else {
                    manga_history = JSON.parse(manga_history)
                    let max_item = 100;
                    manga_history = manga_history.slice(manga_history.length - max_item, max_item);
                }
                manga_history.forEach(function (value, index) {
                    if (value.manga_id !== undefined && value.manga_id === manga_id) {
                        manga_history.splice(index, 1);
                    }
                });
                manga_history.push({
                    manga_id: manga_id,
                    current_reading: {
                        chapter_id: chapter_id,
                        url: window.location.href,
                        name: chapter_name
                    }
                });
                localStorage.setItem('manga_history', JSON.stringify(manga_history));
            }

            $("#error_report").on('click', function () {
                let textReport = prompt(Lang.enter_error, "");
                if (!textReport) {
                    return;
                }
                $.post("/api/report/chapter", {
                    content: textReport,
                    chapter_id: chapter_id
                }, function () {
                    alert(Lang.logged_report)
                });
            })
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.manga18fx.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/manhuarockz.com/resources/views/themes/manga18fx/pages/chapter.blade.php ENDPATH**/ ?>