<?php
$metaConf = getConf('meta');

$replaces = [
    '%manga_name%' => $manga->name,
    '%manga_description%' => $manga->description,
    '%other_name%' => $manga->other_name,
    '%site_name%' => $metaConf['site_name'],
];

foreach ($replaces as $key => $value) {
    if ($value) {
        $metaConf['manga_title'] =
            str_replace($key, $value, $metaConf['manga_title'],);

        $metaConf['manga_description'] =
            str_replace($key, $value, $metaConf['manga_description']);
    }

}

$manga_url = manga_url($manga);
