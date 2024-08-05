<?php
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<rss version="2.0">
    <hannel>
        <title>{{ $metaConf['home_title'] }}</title>
        <link>{{ url('home') }}</link>
        <description>{{ $metaConf['home_description'] }}</description>

        @foreach($manga_rss as $rss)
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
                <title>{{ $metaConf['manga_title'] }}</title>
                <link>{{ manga_url($rss) }}</link>
                <description>{{ !empty($rss->description) ? $rss->description : $metaConf['manga_description'] }}</description>
            </item>
        @endforeach
    </hannel>

</rss>