<?php

namespace Crawler;

use Symfony\Component\DomCrawler\Crawler;

class Manhuarock extends CrawlerCore
{
    public $referer = 'http://manhuarock.wibulord.com/';
    public $proxy = true;


    public function list($page)
    {
        $url = sprintf("http://manhuarock.wibulord.com/manga-genre/manhwa/%s?orderby=views", $page);

        $html = file_get_contents($url);

        if ($html) {
            $crawler = new Crawler($html);

            return array_filter($crawler->filter('.listupd .thumb-manga a')->each(function (Crawler $node) {
                return 'http://manhuarock.wibulord.com' . trim($node->attr('href'));
            }));
        }

        return [];
    }

    public function info($url)
    {
        if (is_array($url)) {
            $dataList = $url;
            $url = $dataList['url'];
        }


        $html = file_get_contents($url);

        if ($html) {
            $crawler = new Crawler($html);

            if ($manga = $crawler->filter('.manga-content')) {
                $outerHtml = $manga->outerHtml();
            } else {
                die('Có lỗi khi lấy dữ liệu!');
            }

            $data['name'] = $manga->filter('.summary_image a img')->attr('title');

            $data['other_name'] = remove_html(explode_by("Alternative:\n</h5>\n</div>", '</div>', $outerHtml));

            $data['cover'] = $manga->filter('.summary_image a img')->attr('src');
            $data['description'] = $crawler->filter('.panel-story-description .dsct')->text();

            $data['taxonomy']['authors'] = remove_html(explode_by("Author(s)\n</h5>\n</div>", '</div>', $outerHtml));
            $data['taxonomy']['authors'] = $data['taxonomy']['authors'] !== "" ? $data['taxonomy']['authors'] : [];

            $data['status'] = remove_html(explode_by("Status\n</h5>\n</div>", '</div>', $outerHtml));
            $data['status'] = $data['status'] == 'OnGoing' ? 'on-going' : 'completed';

            $data['taxonomy']['genres'] = $manga->filter('.genres-content a')->each(function ($node) {
                return $node->text();
            });


            if ($chapter_list = $crawler->filter('.panel-manga-chapter')) {
                $data['list_chapter'] = $chapter_list->filter('.row-content-chapter .a-h a')->each(function (Crawler $node, $i) {
                    $data['name'] = $node->text();

                    if (preg_match('#(chapter|chương|chap)(.[\d.]+)#is', $data['name'], $name) && !empty($name[0])) {
                        $data['name'] = $name[0];
                    }

                    $data['url'] = trim($node->attr('href'));

                    return $data;
                });

                $data['list_chapter'] = array_filter(array_reverse($data['list_chapter']));
            }

            return $data;
        }

        return [];
    }

    public function content($url)
    {

        $chap_id = basename($url);
        $api_url = "http://manhuarock.wibulord.com/ajax/image/list/chap/{$chap_id}?mode=vertical&quality=high";

        $data = file_get_contents($api_url);

        if ($data) {
            $data = json_decode($data, true);

            $html = $data['html'];

            $crawler = new Crawler($html);

            if ($crawler->filter('img')->count() > 0) {
                $data = $crawler->filter('img')->each(function (Crawler $node) {
                    return $node->attr('data-src');
                });

                return [
                    'type' => 'image',
                    'content' => $data
                ];
            }

            $iframe_src = $crawler->filter('iframe')->attr('src');

            if($iframe_src){
                $html = '<iframe src="' . $iframe_src . '" width="100%" height="100%" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe> ';
                return [
                    'type' => 'text',
                    'content' => $html
                ];
            }

        }

        return [];
    }
}
