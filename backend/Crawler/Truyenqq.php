<?php

namespace Crawler;

use Symfony\Component\DomCrawler\Crawler;

class Truyenqq extends CrawlerCore
{
    public $proxy = true;
    public $referer = 'https://truyenqqviet.com/truyen-moi-cap-nhat.html';

    public $config = [];
    
    public function getConfig()
    {
        return $this->config;
    }
    
    public function int()
    {
        $this->config = getConf('truyenqqvn');
        $this->referer = $this->config['root_url'];
        $this->options['headers']['referer'] = $this->referer;
        $this->options['headers']['user-agent'] = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36";
    }

    function list($page = 1)
    {
        $html = $this->bypass( "{$this->config['root_url']}/truyen-moi-cap-nhat/trang-$page.html");

        $crawler = new Crawler($html);

        return array_filter(array_unique($crawler->filter("ul.list_grid li .book_avatar a")->each(function (Crawler $node) {
            return $node->attr('href');
        })));
    }

    function info($url){
        $html = $this->bypass($url);

        $crawler  = new Crawler($html);

        $data['name'] = $crawler->filter(".book_info h1")->text();
        $data['cover'] = $crawler->filter(".book_info img")->attr("src");

        if($crawler->filter("h2.other-name")->count() > 0){
            $data['other_name'] = $crawler->filter("h2.other-name")->text();
        }

        $description = $crawler->filter(".story-detail-info");

        if($description->count() > 0 && strpos($description->text(), 'truyenqqviet') !== false){
            $data['description'] = $description->text();
        }

        $data['status'] = $crawler->filter("ul.list-info li.status .col-xs-9")->text() === 'Đang Cập Nhật' ? 'on-going' : 'completed';

        $listInfo = $crawler->filter(".list-info li")->each(function (Crawler $node){
            return $node->outerHtml();
        });

        foreach ($listInfo as $info){
            $infoCrawler = new Crawler($info);
            if(strpos($info, 'Đang Cập Nhật') !== false){
                continue;
            }

            if(strpos($info, 'Tác giả') !== false){
                $data['taxonomy']['authors'] = $infoCrawler->filter('a')->each(function (Crawler $node){
                    return trim($node->text());
                });
            }
        }

        $data['taxonomy']['genres'] = $crawler->filter(".list01 .li03")->each(function (Crawler $node){
            return $node->text();
        });

        $data['list_chapter'] = $crawler->filter(".works-chapter-item a")->each(function (Crawler $node){            

            preg_match('/(chapter|chương|chap)(.[\d.]+)(.*)/is', $node->text(), $output_array);

            $output_array[2] = trim($output_array[2] ?? $node->text());

            if(!$output_array[2]){
                return [];
            }

            $name_extend = trim($output_array[3] ?? '');
            if($name_extend){
                $name_extend = ltrim($name_extend, '-');
                $name_extend = ltrim($name_extend, ':');
            }

            $name_extend = $name_extend ?? null;
            return [
                'name_extend' => $name_extend,
                'name' => "Chapter " . trim($output_array[2]),
                'url' =>  $node->attr('href')
            ];

        });

        $data['list_chapter'] = array_reverse(array_filter($data['list_chapter']));
        
        return $data;
    }

    function content($url){
        $html = $this->content;
        $crawler = new Crawler($html);

        $chapter['content'] = $crawler->filter(".chapter_content img")->each(function (Crawler $node){
            return $node->attr('src');
        });
        
        // remove first image
        $chapter['content'] = array_slice($chapter['content'], 1);

        $chapter['type'] = 'image';

        return $chapter;
    }
    

    function bypass($url){
        
        $url = sprintf("https://translate.google.com/translate?sl=vi&tl=en&hl=vi&u=%s&client=webapp", urlencode($url));
        $html = $this->curl($url);
        return $html;
    }

}