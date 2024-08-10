<?php

namespace Crawler;

class Goctruyenhay extends CrawlerCore
{
    public $referer = "https://goctruyentranhvui.com";

    const BASE_URL = 'https://goctruyentranhvui.com';
    public $config = [
        // 'cdn' => 'https://afasfsafasf.b-cdn.net',
    ];
    public $token = 'eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJFdGhoYW4gQmFpcmQiLCJjb21pY0lkcyI6W10sInJvbGVJZCI6bnVsbCwiZ3JvdXBJZCI6bnVsbCwiYWRtaW4iOmZhbHNlLCJyYW5rIjowLCJwZXJtaXNzaW9uIjpbXSwiaWQiOiIwMDAwMjA2MDY3IiwidGVhbSI6ZmFsc2UsImlhdCI6MTY3MTA3Mjk2NCwiZW1haWwiOiJudWxsIn0.EftYR7Gv7KgzXfJOrB2F6g0RduY2JcFC83gHRSpuPV67Z0TFe8B-h2CC7tOL9Vz_fMO7MjsRKVy6UaKJ5HDAPw';

    function list($page = 1)
    {
        $data = $this->bypass(self::BASE_URL . "/api/comic/search/recent?p=" . $page);
        $data = \json_decode($data, true);

        $list = [];

        if (isset($data['result']['data'])) {
            foreach ($data['result']['data'] as $item) {
                $list[] = self::BASE_URL . '/truyen/' . $item['nameEn'];
            }
        }

        return $list;
    }

    public function info($url)
    {
        $html = $this->bypass($url);
        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);

        $name = $crawler->filter('h1');
        $name = \trim($name->text());

        $description = $crawler->filter('.comic-content .description .content');
        $description = \trim($description->text());

        $image = $crawler->filter('.comic-content .photo img')->attr('src');

        //remove
        $crawler->filter(".author span, .status span, .other span")->each(function ($crawler) {
            foreach ($crawler as $domElement) {
                $domElement->parentNode->removeChild($domElement);
            }
        });

        $author = $crawler->filter('.author')->text();
        if (str_contains($author, 'Updating')) {
            $author = null;
        } else {
            $author = [
                \trim($author),
            ];
        }

        $status = $crawler->filter('.status')->text();
        $status = \trim($status);
        $status = $status == 'Đang thực hiện' ? 'ongoing' : 'completed';

        $genres = $crawler->filter('.category a')->each(function ($node) {
            return \trim($node->text());
        });

        $comicId = $this->get_string_between($html, "comicId: '", '\'');

        $list_chapter = $this->bypass(self::BASE_URL . "/api/comic/$comicId/chapter?offset=0&limit=-1");
        $list_chapter = \json_decode($list_chapter, true);

        $listchapter = [];
        if (isset($list_chapter['result']['chapters'])) {

            foreach ($list_chapter['result']['chapters'] as $item) {
                $supportType = ['TRIPLE', 'NORMAL'];

                if ($item['rangeBlock'] == 0 && \in_array($item['type'], $supportType) && $item['video'] == false) {
                    $listchapter[] = [
                        'name' => "Chapter " . $item['numberChapter'],
                        'url' => $url . '/chuong-' . $item['numberChapter'],
                        'chapter_index' => $item['numberChapter'],
                    ];
                }
            }
        }

        $listchapter = \array_reverse($listchapter);


        return [
            'name' => $name,
            'description' => $description,
            'cover' => $image,
            'status' => $status,
            'taxonomy' => [
                'genres' => $genres,
                'authors' => $author
            ],
            'list_chapter' => $listchapter,
        ];
    }

    public function content($url)
    {
        $html = $this->bypass($url);

        if (\str_contains($html, 'Để đọc chương này bạn cần đăng nhập bằng tài')) {
            $chapterNum = explode('/chuong-', $url);
            $chapterNum = end($chapterNum);

            $comicId = $this->get_string_between($html, "comicId: '", '\'');
            $data = $this->getLockContent($comicId, $chapterNum);

            if (!empty($data)) {
                $data = json_decode($data, true);
                if (isset($data['result']['state']) && $data['result']['state'] == true) {
                    $data = $data['result']['data'];
                    return [
                        'content' => $data,
                        'type' => 'image',
                    ];
                }
            }

            return [];
        }

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);

        $content = $crawler->filter('.view-section > .viewer img.image')->each(function ($node) {
            return $node->attr('src');
        });

        return [
            'content' => $content,
            'type' => 'image',
        ];
    }

    public function getLockContent($comicId, $chapterNumber)
    {
        $url = $this->config['cdn'] ?? self::BASE_URL . "/api/chapter/auth";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Authorization: Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJFdGhoYW4gQmFpcmQiLCJjb21pY0lkcyI6W10sInJvbGVJZCI6bnVsbCwiZ3JvdXBJZCI6bnVsbCwiYWRtaW4iOmZhbHNlLCJyYW5rIjowLCJwZXJtaXNzaW9uIjpbXSwiaWQiOiIwMDAwMjA2MDY3IiwidGVhbSI6ZmFsc2UsImlhdCI6MTY3MTA3Mjk2NCwiZW1haWwiOiJudWxsIn0.EftYR7Gv7KgzXfJOrB2F6g0RduY2JcFC83gHRSpuPV67Z0TFe8B-h2CC7tOL9Vz_fMO7MjsRKVy6UaKJ5HDAPw",
            "Referer: " . self::BASE_URL,
            "Origin: " . self::BASE_URL,
            "X-Requested-With: XMLHttpRequest"
        );

        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
            'comicId' => $comicId,
            'chapterNumber' => $chapterNumber,
        ]));



        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }

    
    public function bypass($url)
    {
        // change url to transtale google link

        if(isset($this->config['cdn'])){
            $url = \str_replace(self::BASE_URL, $this->config['cdn'], $url);
        }

        return $this->curl($url);
    }
}
