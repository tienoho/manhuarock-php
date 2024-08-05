<?php
$metaConf = getConf('meta');

if (isset($chapter->id)) {
    $replaces = [
        '%manga_name%' => $manga->name,
        '%manga_description%' => $manga->description,
        '%other_name%' => $manga->other_name,
        '%chapter_name%' => $chapter->name,
        '%site_name%' => $metaConf['site_name'],
    ];

    foreach ($replaces as $key => $value) {
        if ($value) {
            $metaConf['chapter_title'] =
                str_replace($key, $value, $metaConf['chapter_title']);
            $metaConf['chapter_description'] =
                str_replace($key, $value, $metaConf['chapter_description']);
        }
    }

    $chapter_url = url('chapter', ['m_slug' => $manga->slug, 'm_id' => $manga->id, 'c_id' => $chapter->id]);
} else {
    include __DIR__ . '/manga.php';

    $metaConf['chapter_title'] = $metaConf['manga_title'];
    $metaConf['chapter_description'] = $metaConf['manga_description'];
}

$manga_url = url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]);
