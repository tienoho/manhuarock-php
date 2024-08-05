<?php
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<rss version="2.0">
    <hannel>
        <title><?php echo e($metaConf['home_title']); ?></title>
        <link><?php echo e(url('home')); ?></link>
        <description><?php echo e($metaConf['home_description']); ?></description>

        <?php $__currentLoopData = $manga_rss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $metaConf = getConf('meta');

            $replaces = [
                '%manga_name%' => $rss->name,
                '%manga_description%' => $rss->description,
                '%other_name%' => $rss->other_name,
                '%site_name%' => $metaConf['site_name'],
            ];

            foreach ($replaces as $key => $value) {
                $metaConf['manga_title'] =
                    str_replace($key, $value, $metaConf['manga_title']);
                $metaConf['manga_description'] =
                    str_replace($key, $value, $metaConf['manga_description']);
            }
            ?>
            <item>
                <title><?php echo e($metaConf['manga_title']); ?></title>
                <link><?php echo e(manga_url($rss)); ?></link>
                <description><?php echo e(!empty($rss->description) ? $rss->description : $metaConf['manga_description']); ?></description>
            </item>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </hannel>

</rss><?php /**PATH /www/wwwroot/mangarock.top/resources/views/rss.blade.php ENDPATH**/ ?>