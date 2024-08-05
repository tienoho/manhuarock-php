<div class="profile-manga" style="background-image: url(/manhwa18cc/images/detail-bg.jpg);">

    <div class="centernav">
        <?php if (! empty(trim($__env->yieldContent('banner-ngang')))): ?>
            <div class="pt-3">
                <?php echo $__env->yieldContent('banner-ngang'); ?>
            </div>
        <?php endif; ?>

        <div class="c-breadcrumb-wrapper">
            <script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "BreadcrumbList",
                        "itemListElement": [
                            {
                                "@type": "ListItem",
                                "position": 1,
                                "name": "<?php echo e(url("home")); ?>",
                                "item": "<?php echo e(url("home")); ?>"
                            },
                            {
                                "@type": "ListItem",
                                "position": 2,
                                "name": "<?php echo e($manga->name); ?>"
                            }
                        ]
                    }


            </script>
            <div class="c-breadcrumb">
                <ol class="breadcrumb">
                    <li>
                        <a href="/" title="Read Webtoons and Korean Manhwa">
                            <?php echo e(L::_("Home")); ?>

                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url()); ?>" title="<?php echo e($manga->name); ?>" class="active"><?php echo e($manga->name); ?> </a>
                    </li>
                </ol>
            </div>
        </div>
        <div class="post-title">
            <h1>
                <?php if($manga->adult): ?>
                    <span>18+</span>
                <?php endif; ?>
                <?php echo e($manga->name); ?> </h1>
        </div>

        <div class="tab-summary ">
            <div class="summary_image">
                <a href="<?php echo e(url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id])); ?>"
                   title="<?php echo e($manga->name); ?>">
                    <img class="img-loading" data-src="<?php echo e($manga->cover); ?>"
                         src="<?php echo e($manga->cover); ?>" alt="<?php echo e($manga->name); ?>"
                         title="<?php echo e($manga->name); ?>">
                </a>
            </div>
            <div class="summary_content_wrap">
                <div class="summary_content">
                    <div class="post-content">
                        <div class="post-rating">
                            <div class="story-rating ">
                                <div class="my-rating jq-stars"></div>
                                <span class="avgrate"><?php echo e($manga->rating_score); ?></span>
                            </div>
                            <div class="is_rate" style="display: none"><?php echo e(L::_("Thanks for your vote!")); ?></div>
                            <div class="post-content_item ">
                                <div class="summary-heading">
                                    <h5>
                                        <?php echo e(L::_("Rating")); ?>:
                                    </h5>
                                </div>
                                <div class="summary-content vote-details" vocab="https://schema.org/"
                                     typeof="AggregateRating">
                                    <div property="itemReviewed" typeof="Book">
                                        <span class="rate-title" property="name"
                                              title="<?php echo e($manga->name); ?>"><?php echo e($manga->name); ?></span>
                                    </div>
                                    <div> Average <span property="ratingValue" id="averagerate"> <?php echo e($manga->rating_score); ?></span> / <span
                                                property="bestRating">5</span>
                                        out of <span property="ratingCount" id="countrate"><?php echo e($manga->total_rating); ?></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="post-content_item ">
                            <div class="summary-heading">
                                <h5>
                                    <?php echo e(L::_("Alternative")); ?>:
                                </h5>
                            </div>
                            <div class="summary-content">
                                <?php echo e($manga->other_name ?? L::_("Updating")); ?>

                            </div>
                        </div>
                        <div class="post-content_item ">
                            <div class="summary-heading">
                                <h5>
                                    <?php echo e(L::_("Author(s)")); ?>

                                </h5>
                            </div>
                            <div class="summary-content">
                                <?php if(!empty(($authors = get_manga_data('authors', $manga->id, [])))): ?>
                                    <div class="author-content">
                                        <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(url('authors', ['authors' => $author->slug])); ?>"
                                               rel="tag"><?php echo e($author->name); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <div class="author-content">
                                        <a href="#" rel="tag"><?php echo e(L::_("Unknown")); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="post-content_item ">
                            <div class="summary-heading">
                                <h5>
                                    <?php echo e(L::_("Artist(s)")); ?>

                                </h5>
                            </div>
                            <div class="summary-content">
                                <div class="artist-content">
                                    <?php if(!empty(($tartists = get_manga_data('artists', $manga->id, [])))): ?>
                                        <?php $__currentLoopData = $tartists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tartist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(url('artists', ['artists' => $tartist->slug])); ?>"
                                               rel="tag"><?php echo e($tartist->name); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="artist-content">
                                            <a href="#" rel="tag"><?php echo e(L::_("Unknown")); ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="post-content_item ">
                            <div class="summary-heading">
                                <h5>
                                    <?php echo e(L::_("Genre(s)")); ?>

                                </h5>
                            </div>
                            <div class="summary-content">
                                <div class="genres-content">
                                    <?php $__currentLoopData = get_manga_data('genres', $manga->id, []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(url('genres', ['genres' => $genre->slug])); ?>"
                                           rel="tag"><?php echo e($genre->name); ?></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="post-content_item ">
                            <div class="summary-heading">
                                <h5>
                                    <?php echo e(L::_("Type")); ?>

                                </h5>
                            </div>
                            <div class="summary-content">
                                <a href="<?php echo e(($manga->type ? url('manga.type', ['type' => $manga->type]) : '#')); ?>"><?php echo e(type_name($manga->type)); ?></a>
                            </div>
                        </div>

                        <div id="init-links" class="nav-links">
                            <?php if(!empty($chapters)): ?>
                                <a id="btn-read-first" class="c-btn c-btn_style-1" href="<?php echo e(url("chapter", [ 'm_slug' => $manga->slug, 'c_slug' => $chapters[count($chapters) - 1]->slug, 'c_id' => $chapters[count($chapters) - 1]->id])); ?>">
                                    <?php echo e(L::_("Read First")); ?>

                                </a>
                                <a id="btn-read-last" class="c-btn c-btn_style-1" href="<?php echo e(url("chapter", [ 'm_slug' => $manga->slug, 'c_slug' => $chapters[0]->slug, 'c_id' => $chapters[0]->id])); ?>">
                                    <?php echo e(L::_("Read Last")); ?>

                                </a>
                            <?php else: ?>
                                <a id="btn-read-first" class="c-btn c-btn_style-1" href="#">
                                    <?php echo e(L::_("Read First")); ?>

                                </a>
                                <a id="btn-read-last" class="c-btn c-btn_style-1" href="#">
                                    <?php echo e(L::_("Read Last")); ?>

                                </a>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="post-status">
                        <div class="post-content_item ">
                            <div class="summary-heading">
                                <h5>
                                    <?php echo e(L::_("Released")); ?>

                                </h5>
                            </div>
                            <div class="summary-content" style="text-align: right">
                                <?php echo e($manga->released ?? L::_("Unknown")); ?>

                            </div>
                        </div>
                        <div class="post-content_item ">
                            <div class="summary-heading">
                                <h5>
                                    <?php echo e(L::_("Status")); ?>

                                </h5>
                            </div>
                            <div class="summary-content" style="text-align: right">
                                <?php echo e(status_name($manga->status)); ?>

                            </div>
                        </div>


                        <div class="manga-action" ng-controller="userFunction" ng-init="getstatus(<?php echo e($manga->id); ?>)">
                            <div class="bookmark-btn " ng-cloak>
                                <div ng-if="!bkresult.status" class="book-mark nbk  "
                                     ng-click="bookmark(<?php echo e($manga->id); ?>)">
                                    <i class="icofont-book-mark"></i> <?php echo e(L::_("Bookmark")); ?>

                                </div>
                                <div ng-if="bkresult.status" class="book-mark ybk  "
                                     ng-click="removebookmark(<?php echo e($manga->id); ?>)">
                                    <i class="icofont-book-mark"></i> <?php echo e(L::_("Followed")); ?>

                                </div>
                                <div class="sumbmrk  ">
                                    <?php echo e($manga->total_bookmarks); ?> <?php echo e(L::_("Users bookmarked")); ?>

                                </div>
                                <?php
                                $x = "{{bkresult.message}}";
                                ?>
                                <div class="bknotice "><?php echo e($x); ?></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /www/wwwroot/2ten.net/resources/views/themes/manga18fx/components/manga/profile.blade.php ENDPATH**/ ?>