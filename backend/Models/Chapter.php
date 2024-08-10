<?php

namespace Models;

//use Config\Chapter as MangaConfig;
class Chapter extends Model
{
    protected $manga;

    public static function ChapterListByID($id, $limit = null, $showhidden = false)
    {
        Chapter::getDB()->where('chapters.manga_id', $id);

        return self::ChapterList($limit, $showhidden);
    }

    public static function ChapterList($limit = null, $showhidden = false)
    {
        if (!$showhidden) {
            Chapter::getDB()->where('chapters.hidden', 0);
        }

        Chapter::getDB()->orderBy('chapters.chapter_index');
        Chapter::getDB()->objectBuilder();
        if (is_login()) {
            Chapter::getDB()->join('user_log_reading', 'user_log_reading.reading_id=chapters.id', 'LEFT');
            Chapter::getDB()->joinWhere('user_log_reading', 'user_log_reading.user_id', userget()->id);
            Chapter::getDB()->groupBy('chapters.name');

            Chapter::getDB()->join('unlocked_chapters', 'unlocked_chapters.chapter_id=chapters.id', 'LEFT');
            Chapter::getDB()->joinWhere('unlocked_chapters', 'unlocked_chapters.user_id', userget()->id);

            return Chapter::getDB()->get('chapters', $limit, 'chapters.id, chapters.views, chapters.price, chapters.name, chapters.hidden, chapters.last_update, chapters.slug, chapters.name_extend, COUNT(user_log_reading.id) as has_read, COUNT(unlocked_chapters.chapter_id) as is_unlocked');
        }

        return Chapter::getDB()->get('chapters', $limit, 'chapters.id, chapters.views, chapters.price, chapters.name, chapters.hidden, chapters.last_update, chapters.slug, chapters.name_extend');
    }

    public static function ChapterByID($id)
    {
        Chapter::getDB()->where('c.id', $id);
        return self::Chapter();
    }

    public static function ChapterBySlug($id, $slug)
    {
        Chapter::getDB()->where('c.manga_id', $id);
        Chapter::getDB()->where('c.slug', $slug);

        return self::Chapter();
    }

    public static function Chapter()
    {
        Chapter::getDB()->where('hidden', 0);
        Chapter::getDB()->orderBy('chapter_index');

        return Chapter::getDB()->objectBuilder()->getOne('chapters c');
    }



    public static function AddMultiChapters(array $chapters)
    {
    }

    public static function AddChapter(array $chapter)
    {
        $allowe_keys = array('name', 'slug', 'chapter_index', 'manga_id', 'hidden');

        foreach ($allowe_keys as $key) {
            $data[$key] = $chapter[$key] ?? NULL;
        }

        $data = array_filter($data);
        // 	id	slug	name	chapter_index	manga_id	views	last_update	hidden
        $id = Chapter::getDB()->insert('chapters', $chapter);

        if (empty($id)) {
            return Chapter::getDB()->getLastError();
        }

        return $id;
    }

    public static function AddChapterContent($data)
    {
        $id = Chapter::getDB()->insert('chapter_data', $data);

        if (empty($id)) {
            return Chapter::getDB()->getLastError();
        }

        return $id;
    }
}