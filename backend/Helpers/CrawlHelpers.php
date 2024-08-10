<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Models\Manga;
use Models\Chapter;
use Models\Taxonomy;

class CrawlHelpers extends Command {
    public $crawler;
    public $site = null;
    public $type = 'Auto';
    public $page = 1;
    public $stop = 1;
    public $mangas_url = [];
    public $info;
    public $save = false;

    function SaveMangaByUrl($url, $site, InputInterface $input, OutputInterface $output){
        $crawler = '\\Crawler\\' . $site;
        $crawl = new $crawler;

        $raw_data = $crawl->info($url);

        if(!$raw_data){
            return;
        }
        // Validate Data
        $data['name'] = $manga['name'] ?? $raw_data['name'];
        $data['slug'] = slugGenerator($raw_data['name']);
        $data['other_name'] = $raw_data['other_name'] ?? NULL;
        $data['cover'] = is_url($raw_data['cover']) ? save_cover($raw_data['cover'], $data['slug'], $crawl->referer) : $raw_data['cover'] ;
        $data['description'] = $raw_data['description'] ?? NULL;
        $data['views'] = $raw_data['views'] ?? 0;
        $data['status'] = $raw_data['status'] ?? 'on-going';
        $data['released'] = isset($raw_data['released']) && is_int($raw_data['released']) ? $raw_data['released'] : NULL;
        $data['country'] = $raw_data['country'] ?? NULL;
        $data['adult'] = $raw_data['adult'] ?? 0;
        $data['type'] = $raw_data['type'] ?? NULL;

        $chapters_index = 1;
        $manga_id = Manga::AddManga($data);
        if (!is_int($manga_id)) {
            if (strpos($manga_id, 'Duplicate entry') !== false) {
                $manga_id = Manga::getDB()->where('name', $data['name'])->orWhere('other_name', $data['other_name'])->getValue('mangas', 'id');
                $chapters_index = Manga::getDB()->where('manga_id', $manga_id)->orderBy('chapter_index', 'DESC')->getValue('chapters', 'chapter_index');
                $chapters_index = $chapters_index + 1;
                $output->writeln(sprintf("<error>Truyện %s đã tồn tại</error>", $data['name']));
            } else {
                $output->writeln($manga_id);
            }
        } else {

            if(isset($raw_data['taxonomy']) && is_array($raw_data['taxonomy'])){
                foreach ($raw_data['taxonomy'] as $taxonomy => $taxonomy_data){
                    if (!empty($taxonomy_data) && is_array($taxonomy_data)) {
                        $taxonomy_data = array_filter($taxonomy_data);

                        Taxonomy::SetTaxonomy($taxonomy, $taxonomy_data, $manga_id);
                    }
                }
            }

            $output->writeln(sprintf("<comment>Đã thêm %s</comment>", $data['name']));
        }

        $output->writeln(['====================', '<comment>Bắt đầu lưu chương mới</comment>']);

        // GET LIST CHAPTER
        if(is_int($manga_id)){
            $has_chapter = false;
            $list_chapters = $raw_data['list_chapter'];

            foreach ($list_chapters as $chapter) {
                $data_chapter['name'] = $chapter['name'];
                $data_chapter['slug'] = slugGenerator($chapter['name']);
                $data_chapter['chapter_index'] = $chapters_index;
                $data_chapter['manga_id'] = $manga_id;
                $data_chapter['views'] = $chapter['views'] ?? 0;
                $data_chapter['hidden'] = 0;
                $chapter_id = Chapter::AddChapter($data_chapter);

                if (!is_int($chapter_id)) {
                    if (strpos($chapter_id, 'Duplicate entry') !== false) {
                        $output->writeln(sprintf("<error> %s đã tồn tại</error>", $chapter['name']));
                    } else if (strpos($chapter_id, 'a foreign key constraint') !== false) {
                        $output->writeln('<error>Truyện không tồn tại</error>');
                    } else {
                        $output->writeln($chapter_id);
                    }
                } else {

                    $chapter_content['type'] = $chapter['type'] ?? 'leech';
                    $chapter_content['chapter_id'] = $chapter_id;
                    $chapter_content['content'] = $chapter['url'];
                    $chapter_content['storage'] = $site;
                    $chapter_content['storage_name'] = 'Server 1';

                    $id = Chapter::AddChapterContent($chapter_content);

                    if (!is_int($id)) {
                        $output->writeln($id);
                    }

                    $output->writeln(sprintf("Đã Thêm %s", $chapter['name']));
                    $has_chapter = true;
                    $chapters_index = $chapters_index + 1;
                }


            }

            if($has_chapter){
                Manga::UpdateLastChapter($manga_id);
            }
        }

        $output->writeln(['====================', '<comment>Xong bộ này</comment>']);
    }

    function scraplist(): array
    {
        $fileList = glob(ROOT_PATH. '/backend/Crawler/*.php');
        $list = [];
        foreach($fileList as $filename){
            if(is_file($filename)){
                if(strpos( $filename, 'CrawlerCore') === false){
                    $list[] = str_replace( '.php', '', basename($filename));
                }
            }
        }

        return $list;
    }

    function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch,CURLOPT_REFERER,$this->crawler->referer);
        $data = curl_exec ($ch);
        curl_close ($ch);
        return $data;
    }


    function isBinary($value): bool
    {
        return false === mb_detect_encoding((string)$value, null, true);
    }

}