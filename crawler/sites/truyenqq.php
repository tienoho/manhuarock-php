<?php
$url = $config['sites']['truyenqq']['home_page'];

//print('url:'.$url);

$session = json_decode($fsSessionManager->createSession(), true);
$sessionId = $session['session'];

$response = $fsSessionManager->getContent($url, $sessionId);
$string = '';
if ($response !== false) {
    $json_response = json_decode($response, true);
    if ($json_response['status'] == 'ok') {
        $string = $json_response['solution']['response'];
    }
}
preg_match_all('#<h3><a.*href="(.*)">(.*)</a></h3>#imsU', $string, $urlList);
$mangaList = array_combine($urlList[1], $urlList[2]);
//$mangaList = array_slice($mangaList, 0, 1);
//print_r($urlList);
foreach ($mangaList as $url => $name) {
    $response = $fsSessionManager->getContent($url, $sessionId);
    if ($response !== false) {
        $json_response = json_decode($response, true);
        if ($json_response['status'] == 'ok') {
            $string = $json_response['solution']['response'];
        }
    }
    $slug    = $helper->slug(trim($name));
    $checker = $db->join('chapters', 'mangas.id = chapters.manga_id', 'LEFT')->where('mangas.slug', $slug)->orderBy('chapters.chapter_index', 'DESC')->getOne('mangas', 'mangas.id, mangas.slug, chapters.chapter_index');
    
    //print('slug' . $slug.''. PHP_EOL);
    
    if ($checker) {
        
        //print('$checker' . $checker['id'] .''. PHP_EOL);
        
        $manga_id      = $checker['id'];
        if (!$checker['chapter_index']) {
            $grab_tap = 0;
        } else {
            $grab_tap = $checker['chapter_index'];
        }

        preg_match('#class="works-chapter-list">(.*)<input type="hidden"#imsU', $string, $content);
        preg_match_all('#<a.*href="(.*)">(.*)</a>#imsU', $content[1], $chapList);

        $chapterList      = [];
        $chapterList[1]   = array_reverse($chapList[1]);
        $chapterList[2]   = array_reverse($chapList[2]);

        foreach ($chapterList[2] as $key => $value) {
            preg_match('#(chapter|chap|chương|chuong) ([\d.]+)#si', $value, $chapterBreak);
            if ($chapterBreak[2] > $grab_tap) {
                break;
            }
            unset($chapterList[1][$key]);
            unset($chapterList[2][$key]);
        }
        
        //print_r($chapList);
        //print_r(PHP_EOL);
        
        if (count($chapterList[2]) > 0) {
            $myArray = array_combine($chapterList[1], $chapterList[2]);

            foreach ($myArray as $chapterUrl => $chapterName) {
                preg_match('#(chapter|chap|chương|chuong) ([\d.]+)#is', $chapterName, $chapter);
                $dataInputChapter = [
                    'name' => $chapterName,
                    'slug' => $helper->slug($chapterName),
                    'name_extend' => '',
                    'chapter_index' => $chapter[2],
                    'manga_id' => $manga_id,
                    'created_by' => 1,
                    'last_update' => $db->now(),
                    'hidden' => 1
                ];
                $chapterId = $db->insert('chapters', $dataInputChapter);
                if ($chapterId) {
                    $result = $db->insert('crawl_chapters', array('chapter_id' => $chapterId, 'manga_id' => $manga_id, 'url' => $chapterUrl, 'created_at' => $db->now()));
                }
            }
            print($name . ' lấy thêm ' . count($chapterList[2]) . ' chương' . PHP_EOL);
        }
        
    } else {
        //exit();
        
        preg_match('#class="list-info">(.*)</ul>#imsU', $string, $content);
        preg_match('#<h1 itemprop="name">(.*)</h1>#imsU', $string, $name);
        preg_match('#class="status row">.*class="col-xs-9">(.*)</p>#imsU', $content[1], $m_status);
        preg_match('#class="author row">(.*)</li>#imsU', $content[1], $tacgia);
        preg_match_all('#<a.*>(.*)</a>#imsU', $tacgia[1], $authors);
        preg_match('#class="list01">(.*)</ul>#imsU', $string, $theloai);
        preg_match_all('#<a.*>(.*)</a>#imsU', $theloai[1], $genres);
        preg_match('#detail-content">(.*)</div>#imsU', $string, $desc);
        preg_match('#<meta itemprop="image" content="(.*)">#imsU', $string, $cover);

        $manga['name']        = !empty($name[1]) ? trim($name[1]) : '';
        $manga['other_name']  = null;
        $manga['slug']        = $helper->slug($manga['name']);
        if (strpos(trim($m_status[1]), 'Đang Cập Nhật') !== false) {
            $manga['status'] = 'ongoing';
        } else {
            $manga['status'] = 'completed';
        }

        $opts                 = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\r\n" .
                    "Accept-Language: vi,vi-VN;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5\r\n" .
                    "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Mobile Safari/537.36\r\n" .
                    "Referer: ". $config['sites']['truyenqq']['home_page'] ."",
            ),
        );
        $context = stream_context_create($opts);
        if (copy($cover[1], '../publish/uploads/covers/' . $manga['slug'] . '.jpg', $context)) {
            $manga['cover'] = '/uploads/covers/' . $manga['slug'] . '.jpg';
        } else {
            $manga['cover'] = !empty($cover[1]) ? trim($cover[1]) : '';
        }
        $manga['description'] = !empty($desc[1]) ? trim(strip_tags($desc[1])) : '';

        $manga['created_by']   = 1;
        $manga['created_at'] = $db->now();

        $manga_id = 1;
        $manga_id  = $db->insert('mangas', $manga);

        if ($manga_id) {
            // add genres
            foreach ($genres[1] ?? [] as $genre) {
                $genreSlug = $helper->slug($genre);
                $genreId = $db->onDuplicate(['created_by'], 'id')->insert('taxonomy', ['name' => $genre, 'slug' => $genreSlug, 'taxonomy' => 'genres', 'created_by' => 1]);
                if ($genreId) {
                    $db->onDuplicate(['taxonomy_id'], 'id')->insert('taxonomy_manga', ['manga_id' => $manga_id, 'taxonomy_id' => $genreId]);
                }
            }
            // add authors
            foreach ($authors[1] ?? [] as $author) {
                $authorSlug = $helper->slug($author);
                $authorId = $db->onDuplicate(['created_by'], 'id')->insert('taxonomy', ['name' => $author, 'slug' => $authorSlug, 'taxonomy' => 'authors', 'created_by' => 1]);
                if ($authorId) {
                    $db->onDuplicate(['taxonomy_id'], 'id')->insert('taxonomy_manga', ['manga_id' => $manga_id, 'taxonomy_id' => $authorId]);
                }
            }

            preg_match('#class="works-chapter-list">(.*)<input type="hidden"#imsU', $string, $content);
            preg_match_all('#<a.*href="(.*)">(.*)</a>#imsU', $content[1], $list_chap);

            $list_chapter    = [];
            $list_chapter[1] = array_reverse($list_chap[1]);
            $list_chapter[2] = array_reverse($list_chap[2]);
            $arr             = array_combine($list_chapter[1], $list_chapter[2]);

            foreach ($arr as $chapterUrl => $chapterName) {
                preg_match('#(chapter|chap|chương|chuong) ([\d.]+)#is', $chapterName, $chapter);
                $dataInputChapter = [
                    'name' => $chapterName,
                    'slug' => $helper->slug($chapterName),
                    'name_extend' => '',
                    'chapter_index' => $chapter[2],
                    'manga_id' => $manga_id,
                    'created_by' => 1,
                    'last_update' => $db->now(),
                    'hidden' => 1
                ];
                $chapterId = $db->insert('chapters', $dataInputChapter);
                if ($chapterId) {
                    $result = $db->insert('crawl_chapters', array('chapter_id' => $chapterId, 'manga_id' => $manga_id, 'url' => $chapterUrl, 'created_at' => $db->now()));
                }
            }
            print($manga['name'] . ' mới có ' . count($list_chapter[2]) . ' chương' . PHP_EOL);
        }
    }
}


$fsSessionManager->destroySession($sessionId);
