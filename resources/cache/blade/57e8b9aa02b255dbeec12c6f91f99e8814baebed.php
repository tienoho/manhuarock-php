<div class="c-breadcrumb-wrapper">
    <script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "BreadcrumbList",
                        "itemListElement": [{
                            "@type": "ListItem",
                            "position": 1,
                            "name": "<?php echo e(L::_("Home")); ?>",
                            "item": "<?php echo e(url('home')); ?>"
                        },{
                            "@type": "ListItem",
                            "position": 2,
                            "name": "<?php echo e($manga->name); ?>",
                            "item": "<?php echo e($manga_url); ?>"
                        },{
                            "@type": "ListItem",
                            "position": 3,
                            "name": "<?php echo e($chapter->name); ?>"
                        }]
                    }

                    </script>
    <div class="c-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(url('home')); ?>" title="<?php echo e(L::_("Read Manga Online")); ?>">
                    <?php echo e(L::_("Home")); ?>

                </a>
            </li>
            <li>
                <a href="<?php echo e(url('manga', ['m_slug'=> $manga->slug, 'm_id' => $manga->id])); ?>"
                   title="<?php echo e($manga->name); ?>">
                    <?php echo e($manga->name); ?> </a>
            </li>
            <li>
                <a class="active" href="<?php echo e(url()); ?>"
                   title="<?php echo e($manga->name); ?> <?php echo e($chapter->name); ?>">
                    <?php echo e($chapter->name); ?> </a>
            </li>
        </ol>
    </div>
</div>
<?php /**PATH F:\PHP\HMT\resources\views/themes/manga18fx/components/chapter/breadcrumb.blade.php ENDPATH**/ ?>