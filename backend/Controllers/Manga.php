<?php

namespace Controllers;

use Models\Chapter as ChapterModel;
use Models\Manga as MangaModel;
use Models\History as HistoryModel;
use Models\Model;
use Services\Blade;

class Manga
{

    public function index($page = 1): string
    {

        $blable = new Blade;

        $orderby = input()->value('orderby');
        $params = $orderby ? ['orderby' => $orderby] : null;
        // .index
        return $blable->render('themes.' . app_theme() . '.pages.home', ["page" => $page, 'params' => $params, 'url_name' => 'home_page']);
    }

    public function show($m_slug, $m_id = false)
    {
        $manga = MangaModel::MangaBySlug($m_slug);

        if (empty($manga)) {
            response()->redirect('/', 301);
        } else {
            if ($manga->slug !== $m_slug) {
                response()->redirect(url('manga', ['m_id' => $manga->id, 'm_slug' => $manga->slug]), 301);
            }
        }

        $chapters = ChapterModel::ChapterListByID($manga->id);

        return (new Blade)->render('themes.' . app_theme() . '.pages.manga', ["manga" => $manga, "chapters" => $chapters]);
    }

    public function showChapter($m_slug, $c_slug = null, $c_id = null)
    {
        $render_data = [];
        $manga = MangaModel::MangaBySlug($m_slug);
        $render_data['user_id'] = '';
        $render_data['manga'] = $manga;
        $render_data['chapter'] = [
            'id' => '',
            'name' => '',
            'slug' => '',
        ];

        if ($c_slug) {
            $chapter = ChapterModel::ChapterBySlug($manga->id, $c_slug);
            if (empty($manga)) {
                response()->redirect('/');
            }

            if (empty($chapter)) {
                response()->redirect(manga_url($manga));
            }

            if ($manga->slug !== $m_slug || $c_slug != $chapter->slug) {
                response()->redirect(chapter_url($manga, $chapter));
            }

            $render_data['chapter'] = $chapter;

            if (getConf('site')['theme'] !== 'mangareader') {
                Model::getDB()->where('chapter_id', $chapter->id);
                $chapter_data = Model::getDB()->objectBuilder()->getOne('chapter_data');

                if ($chapter_data->type == 'image') {
                    $chapter_data->content = json_decode($chapter_data->content);
                }

                $render_data['chapter_data'] = $chapter_data;
            }

        }

        if (is_login()) {
            $render_data['user_id'] = userget()->id;

           //$historyModel = new HistoryModel();

            //$history = new HistoryModel();
            //$history->recordReading(userget()->id, $manga->id, $chapter->id);
        }

        $blable = new Blade;

        return $blable->render(
            'themes.' . app_theme() . '.pages.chapter',
            $render_data
        );
    }

    public function imageListChap($chapter_id)
    {
        $blable = new Blade;
        $mode = input()->value('mode', 'vertical');

        Model::getDB()->where('id', $chapter_id);
        $chapters = Model::getDB()->objectBuilder()->getOne('chapters', 'id, created_by, last_update, price');

        if (!is_object($chapters) || !isset($chapters->id) ) {
            response()->json([
                'msg' => 'Chap này không tồn tại hoặc đã bị xoá',
            ]);
        }

        Model::getDB()->where('chapter_id', $chapter_id);
        $chapter_data = Model::getDB()->objectBuilder()->getOne('chapter_data');

        if (!is_object($chapter_data) || !isset($chapter_data->id) ) {
            response()->json([
                'msg' => 'Chap này không tồn tại hoặc đã bị xoá',
            ]);
        }

        // response()->json([
        //     'chapter_data' => $chapter_data,
        // ]);

        switch ($chapter_data->type) {
            case 'leech':
                $storage = "\\Crawler\\$chapter_data->storage";
                $crawler = new $storage;
                $data = $crawler->content($chapter_data->content);

                $chapter_data->content = $data['content'];
                $chapter_data->type = $data['type'];

                if ($chapter_data->type == 'image' && is_array($chapter_data->content)) {
                    foreach ($chapter_data->content as $key => $image_url) {
                        if ($crawler->proxy) {
                            $chapter_data->content[$key] = url('proxy', null, ['data' => base64_encode("$chapter_data->storage|$image_url")]);
                        }
                    }
                }
                break;
            case 'image':
                $chapter_data->content = json_decode($chapter_data->content);

                break;
            case 'text':

                break;
        }

        $views = 'themes.' . app_theme() . ".components.chapter.$mode-image-list";

        if (isset($chapters->price) && $chapters->price > 0) {
            $views = 'themes.' . app_theme() . ".components.chapter.locked";

            if (is_login()) {
                $unlocked = Model::getDB()
                    ->where('user_id', userget()->id)
                    ->where('chapter_id', $chapter_id)->getOne('unlocked_chapters');

                if (isset($unlocked)) {
                    $views = 'themes.' . app_theme() . ".components.chapter.$mode-image-list";
                }
            }
        }
        
        $html = $blable->make($views, ['chapter' => $chapters, 'chapter_id' => $chapter_id, 'chapter_data' => $chapter_data])->render();

        response()->httpCode(200)->json(['status' => true, 'html' => $html]);
    }

    public function sourceListChap($chapter_id)
    {
        $blable = new Blade;
        $mode = input()->value('mode', 'vertical');

        Model::getDB()->where('id', $chapter_id);
        $chapters = Model::getDB()->objectBuilder()->getOne('chapters', 'id, created_by, last_update, price');

        if (!is_object($chapters) || !isset($chapters->id) ) {
            response()->json([
                'msg' => 'Chap này không tồn tại hoặc đã bị xoá',
            ]);
        }

        Model::getDB()->where('chapter_id', $chapter_id);
        $chapter_data = Model::getDB()->objectBuilder()->getOne('chapter_data');

        if (!is_object($chapter_data) || !isset($chapter_data->id) ) {
            response()->json([
                'msg' => 'Chap này không tồn tại hoặc đã bị xoá',
            ]);
        }
        
        switch ($chapter_data->type) {
            case 'leech':
                $storage = "\\Crawler\\$chapter_data->storage";
                $crawler = new $storage;
                $data = $crawler->content($chapter_data->content);

                $chapter_data->content = $data['content'];
                $chapter_data->type = $data['type'];

                if ($chapter_data->type == 'image' && is_array($chapter_data->content)) {
                    foreach ($chapter_data->content as $key => $image_url) {
                        if ($crawler->proxy) {
                            $chapter_data->content[$key] = url('proxy', null, ['data' => base64_encode("$chapter_data->storage|$image_url")]);
                        }
                    }
                }
                break;
            case 'image':
                $chapter_data->content = json_decode($chapter_data->content);

                break;
            case 'text':

                break;
        }

        $views = 'themes.' . app_theme() . ".components.chapter.$mode-image-list";

        if (isset($chapters->price) && $chapters->price > 0) {
            $views = 'themes.' . app_theme() . ".components.chapter.locked";

            if (is_login()) {
                $unlocked = Model::getDB()
                    ->where('user_id', userget()->id)
                    ->where('chapter_id', $chapter_id)->getOne('unlocked_chapters');

                if (isset($unlocked)) {
                    $views = 'themes.' . app_theme() . ".components.chapter.$mode-image-list";
                }
            }
        }
        
        $html = $blable->make($views, ['chapter' => $chapters, 'chapter_id' => $chapter_id, 'chapter_data' => $chapter_data])->render();

        response()->httpCode(200)->json(['status' => true, 'html' => $html]);
    }

    public function readingList($manga_id)
    {
        $blable = new Blade;
        MangaModel::getDB()->where('id', $manga_id);
        MangaModel::getDB()->where('hidden', 0);
        $manga_slug = MangaModel::getDB()->getValue('mangas', 'slug');

        if (!$manga_slug) {
            response()->httpCode(404)->redirect('/');
        }

        $chapters = ChapterModel::ChapterListByID($manga_id);
        $html = $blable->make('themes.' . app_theme() . ".components.chapter.reading-list", ['chapters' => $chapters, 'manga_slug' => $manga_slug])->render();
        $data = ['status' => true, 'html' => $html];
        if (is_login()) {
            //            $data['continueReading'] = Model::getDB()->where('manga_id', $manga_id)->where('user_id', userget()->id)->objectBuilder()->getOne('user_log_reading');
            $data['settings'] = json_decode(userget()->settings);
        }

        response()->httpCode(200)->json($data);
    }

    public function viewsCount($chapter_id)
    {

        Model::getDB()->where('id', $chapter_id);
        $chapters = Model::getDB()->objectBuilder()->getOne('chapters', 'manga_id, created_by');
        $manga_id = $chapters->manga_id;

        if (!$manga_id) {
            response()->httpCode(403)->json(['msg' => 'Request không hợp lệ']);
        }

        Model::getDB()->rawQuery("UPDATE mangas SET views = views + 1, views_day = views_day + 1, views_week = views_week + 1, views_month = views_month + 1 WHERE id = $manga_id");

        // If earned money turn on
        $ip = ip2long(request()->getIp());

        if (empty($ip)) {
            response()->httpCode(403)->json(['msg' => 'IP không hợp lệ']);
        }

        $now = Model::getDB()->now();

        Model::getDB()->where('ip', $ip);
        Model::getDB()->where('chapter_id', $chapter_id);

        $time = Model::getDB()->getValue('chapter_views', 'created_at');

        if (!$time || (strtotime('+1 day') - strtotime($time) <= 0)) {
            $administration_conf = getConf('administration');
            $rate = $administration_conf['rate'];

            $insert_data = [
                'ip' => $ip,
                'chapter_id' => $chapter_id,
                'created_at' => $now,
            ];

            if ($chapters->created_by !== null) {
                $insert_data['rate'] = $rate;
            }

            Model::getDB()->insert('chapter_views', $insert_data);

            Model::getDB()->rawQuery("UPDATE chapters SET views = views + 1, earned = earned + $rate WHERE id = $chapter_id");

            response()->json(['status' => true]);
        }

        response()->json(['status' => false]);
    }

    public function voteSubmit()
    {
        if (!request()->isAjax()) {
            response()->httpCode(403);
        }

        $mangaID = input()->value('mangaId');
        $mark = input()->value('mark');

        $ip = request()->getIp();
        $max = 10;
        if (!$ip || !$mangaID || $mark > $max || $mark <= 0) {
            response()->json([
                'status' => false,
                'msg' => 'Yêu cầu không hợp lệ, không thể khi nhận đánh giá!',
            ]);
        }

        $manga = Model::getDB()->where('id', $mangaID)
            ->objectBuilder()
            ->getOne('mangas', 'total_rating, rating_score');

        if (!$manga) {
            response()->httpCode(403);
        }

        if (Model::getDB()->where('ip', $ip)->where('manga_id', $mangaID)->getValue('ratings', 'id')) {
            response()->json([
                'status' => false,
                'msg' => 'Bạn đã đánh giá truyện này rồi!',
            ]);
        }

        $manga->total_rating = $manga->total_rating + 1;

        if ($manga->rating_score !== 0) {
            $manga->rating_score = (($manga->rating_score * ($manga->total_rating - 1)) + $mark) / $manga->total_rating;
            $manga->rating_score = floor($manga->rating_score * 2) / 2;
        } else {
            $manga->rating_score = $mark;
        }

        Model::getDB()->where('id', $mangaID)->update('mangas', [
            'rating_score' => $manga->rating_score,
            'total_rating' => $manga->total_rating,
        ]);

        Model::getDB()->insert('ratings', [
            'ip' => $ip,
            'manga_id' => $mangaID,
            'rate' => $mark,
        ]);

        response()->json([
            'status' => true,
            'msg' => 'Hệ thống đã ghi nhận đánh giá của bạn',
        ]);
    }

    public function GetMangas()
    {
        $template = input()->value('template');
        $data = input()->value('data');

        if (empty($data)) {
            return;
        }

        $data = json_decode($data);

        $manga_ids = [];

        foreach ($data as $item) {
            $manga_ids[] = $item->manga_id;
            $current_reading[$item->manga_id] = $item->current_reading;
        }

        if (!$manga_ids) {
            return;
        }
        Model::getDB()->Orwhere('id', $manga_ids, 'IN');

        Model::getDB()->where('hidden', 0);

        $mangas = Model::getDB()->objectBuilder()->get('mangas');

        $sortRead = [];
        foreach ($manga_ids as $id) {
            foreach ($mangas as $manga) {
                if ($manga->id == $id) {
                    $sortRead[] = $manga;
                }
            }
        }

        $path = 'themes.' . app_theme() . ".template.$template";

        return (new Blade())->render($path, [
            'mangas' => $sortRead,
            'current_reading' => $current_reading,
        ]);
    }

    public function readRandom()
    {
        Model::getDB()->orderBy("RAND ()");
        Model::getDB()->where('hidden', 0);

        $manga = Model::getDB()->objectBuilder()->getOne('mangas');

        $manga_url = manga_url($manga);

        header('Location: ' . $manga_url);
    }

    public function seachSuggest()
    {
        $keyword = input()->value('keyword');
        if (!empty($keyword)) {

        }

        Model::getDB()->where('hidden', 0);

        Model::getDB()->orderBy("name");

        Model::getDB()->where('name', "%$keyword%", 'LIKE');
        Model::getDB()->orWhere('other_name', "%$keyword%", 'LIKE');

        $mangas = Model::getDB()->objectBuilder()->get('mangas', 5);

        header('Content-Type: application/json');

        return json_encode([
            'status' => true,
            'html' => (new Blade())->render('themes.' . app_theme() . '.components.ajax.suggest', [
                'mangas' => $mangas,
                'keyword' => $keyword,
            ]),
        ]);
    }

    function unlockChapterTemplate($chapter_id){
        Model::getDB()->where('id', $chapter_id);
        $chap = Model::getDB()->objectBuilder()->getOne("chapters");

        return (new Blade())->render('themes.' . app_theme() . '.template.unlock-chapter-template', [
            'chap' => $chap,
            'chapter_id' => $chapter_id,
        ]);
    }
}