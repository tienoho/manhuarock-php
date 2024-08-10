<?php

namespace Command;

use Ausi\SlugGenerator\SlugGenerator;
use Config\Crawl;
use Exception;
use Models\Manga;
use Models\Model;
use Models\Taxonomy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use CrawlHelpers;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class CrawlData extends CrawlHelpers
{
    use LockableTrait;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'crawl:data';
    public $is_new = false;

    protected function configure(): void
    {
        $this->setDescription('Quét truyện mới');
        $this->setHelp('Lệnh quyét truyện mới');

        $this->addArgument('site', InputArgument::OPTIONAL, 'Site Quét');

        $this->addOption(
            'page',
            null,
            InputOption::VALUE_OPTIONAL,
            'Page Quét',
            1
        );

        $this->addOption(
            'stop',
            null,
            InputOption::VALUE_OPTIONAL,
            'Page dừng',
            1
        );

        $this->addOption(
            'cron',
            null,
            InputOption::VALUE_OPTIONAL,
            'Set true khi sử dụng crontab',
            false
        );

        $this->addOption(
            'url',
            null,
            InputOption::VALUE_OPTIONAL,
            'Set true khi sử dụng crontab',
            false
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $is_cron = $input->getOption('cron');

        $this->site = $input->getArgument('site');
        $this->page = $input->getOption('page');
        $this->stop = $input->getOption('stop');

        if (!$is_cron) {
            $helper = $this->getHelper('question');

            if (!$this->site) {
                $output->writeln('<comment>Bỏ trống mặc định = 0</comment>');

                $site = new ChoiceQuestion("Chọn nguồn: ", $this->scraplist());
                $type = new ChoiceQuestion("Loại leech: ", [
                    0 => 'Auto',
                    1 => 'Tuỳ chọn'
                ], 0);

                $this->site = $helper->ask($input, $output, $site);
                $this->type = $helper->ask($input, $output, $type);
            }

            if ($this->type == 'Tuỳ chọn') {
                $link = new Question("Nhập URL: ", null);
                $this->page = 1;
                $this->mangas_url = [
                    $helper->ask($input, $output, $link)
                ];

                $this->page = 1;
                $this->stop = 1;
            } else {
                if ($this->page == 1) {
                    $output->writeln('<comment>Bỏ trống mặc định = 1</comment>');

                    $page = new Question("Nhập page max: ", 1);
                    $this->page = $helper->ask($input, $output, $page);
                }

                if ($this->stop == 1) {
                    $output->writeln('<comment>Bỏ trống mặc định = 1</comment>');

                    $stop = new Question("Dừng khi quét tới page: ", 1);
                    $this->stop = $helper->ask($input, $output, $stop);
                }
            }
        }

        $this->crawler = '\\Crawler\\' . $this->site;
        $this->crawler = new $this->crawler;

        if($input->getOption('url')){
            $this->mangas_url = [
                $input->getOption('url')
            ];
        }

        while ($this->page >= $this->stop) {

            if (empty($this->mangas_url)) {
                $this->mangas_url = $this->crawler->list($this->page);
                $output->writeln("<comment>Đã quét page $this->page</comment>");
            }

            foreach ($this->mangas_url as $url) {
                $this->CheckNewChap($url, $input, $output);
            }

            $this->mangas_url = [];
            $this->page--;
        }


        $output->writeln("<comment>=========================</comment>");
        return Command::SUCCESS;
    }

    function CheckNewChap($url, InputInterface $input, OutputInterface $output)
    {
        $this->info = $this->crawler->info($url);
        
        $config = $this->crawler->getConfig();

        if (empty(trim($this->info['name']))) {
            return;
        }

        if (in_array($this->info['name'], Crawl::BLACKLIST_NAME)) {
            $output->writeln("Truyện trong black list: " . $this->info['name']);
            return;
        }

        $this->info['slug'] = SlugGenerator($this->info['name']);
        Model::getDB()->where('name', $this->info['name']);
        Model::getDB()->Orwhere('other_name', $this->info['name']);

        Model::getDB()->Orwhere('slug', $this->info['slug']);

        if (!empty($this->info['other_name'])) {
            Model::getDB()->Orwhere('other_name', $this->info['other_name']);
            Model::getDB()->Orwhere('name', $this->info['other_name']);
        }

        $manga_id = Model::getDB()->getValue('mangas', 'id');

        if (!$manga_id) {
            $this->is_new = true;
            try {
                $manga_id = $this->SaveManga();
            } catch (Exception $e){
                print_r($this->info);
            }
            if (!$manga_id) {
                print_r(Model::getDB()->getLastError());
                $output->writeln('Xảy ra lỗi khi lưu truyện: ' . $this->info['name']);
                return;
            }

            $output->writeln('Đã lưu truyện: ' . $this->info['name']);
        }
        
        $output->writeln('Bắt đầu quét chương: ' . $this->info['name']);

        $has_new = false;
        $chapters_index = 0;
        $result_chapter = [];

        if (!$this->is_new) {
            //lấy list chapter trong data
            $result_chapter = Model::getDB()->where('manga_id', $manga_id)->get('chapters');
        }
        
//$output->writeln('đã vào đây');

        foreach ($this->info['list_chapter'] as $chap) {

            $insert_data['name'] = $chap['name'];
            $insert_data['name_extend'] = $chap['name_extend'] ?? NULL;
            $insert_data['slug'] = slugGenerator($chap['name']);
            $insert_data['chapter_index'] = $chapters_index++;
            $insert_data['manga_id'] = $manga_id;
            $insert_data['hidden'] = 0;
            $insert_data['views'] = 0;
            $insert_data['last_update'] = Model::getDB()->now(); 
            $insert_data['hidden'] = 1;

            if (!$this->is_new) {
                 Model::getDB()->where('manga_id', $insert_data['manga_id']);
                 Model::getDB()->where("(name = ? or slug = ?)", Array($insert_data['name'],$insert_data['slug']));
                // Sử dụng phương thức getOne() hoặc withTotalCount() để kiểm tra kết quả truy vấn
                $result = Model::getDB()->getOne('chapters'); // Hoặc có thể sử dụng ->withTotalCount()
                if ($result) {
                    $output->writeln(sprintf("<error> %s đã tồn tại</error>", $chap['name']));
                    //$output->writeln($result);
                    continue;
                }
            }

            Model::getDB()->startTransaction();

            $chap_id = Model::getDB()->insert('chapters', $insert_data);
            if (!isset($chap_id) || !is_int($chap_id)) {
                Model::getDB()->rollback();
                $error = Model::getDB()->getLastError();
                if (strpos($error, 'Duplicate entry') !== false) {
                    $output->writeln( $error);
                    $output->writeln(sprintf("<error> %s đã tồn tại</error>", $chap['name']));
                    continue;
                }
                if (strpos($error, 'a foreign key constraint') !== false) {
                    $output->writeln('<error>Truyện không tồn tại</error>');
                    return;
                }
                $output->writeln('Lỗi không thể lưu: ' . $insert_data['name']);
                $output->writeln($error);
                return;
            }

            // insert to queue
            $inputInfo = [
                    'manga_id' => $manga_id,
                    'chapter_id' => $chap_id,
                    'url' => preg_replace('/^https?:\/\/([^\/]+)/i', $config['root_url'], $chap['url']),
                    'status' => 1
                ];
            $content_id = Model::getDB()->insert('crawl_chapters', $inputInfo);
            
            if (!isset($content_id) || !is_int($content_id)) {
                $output->writeln(Model::getDB()->getLastError());
                $output->writeln('Xãy ra lỗi không thể lưu nội dung, vui lòng kiểm tra');

                Model::getDB()->rollback();
                return;
            }

            Model::getDB()->commit();
            $has_new = true;
            $output->writeln('Đã lưu: ' . $chap['name']);
        }

        if ($has_new) {
            Manga::UpdateLastChapter($manga_id);
        }
    }

    function SaveManga()
    {
        if (empty($this->info)) {
            return 0;
        }

        $data['name'] = $this->info['name'];
        $data['slug'] = $this->info['slug'];
        $data['other_name'] = $this->info['other_name'] ?? NULL;
        $data['cover'] = is_url($this->info['cover']) ? save_cover($this->info['cover'], $this->info['slug'], $this->crawler->referer) : $this->info['cover'];
        $data['description'] = $this->info['description'] ?? NULL;
        $data['views'] = $this->info['views'] ?? 0;
        $data['status'] = $this->info['status'] ?? 'on-going';
        $data['released'] = isset($this->info['released']) && is_numeric($this->info['released']) ? $this->info['released'] : NULL;
        $data['country'] = $this->info['country'] ?? NULL;
        $data['adult'] = $this->info['adult'] ?? 0;
        $data['type'] = $this->info['type'] ?? NULL;

        $manga_id = Manga::AddManga($data);

        if (!is_numeric($manga_id)) {
            if (strpos($manga_id, 'Duplicate entry') !== false) {
                $output->writeln(sprintf("<error>Truyện %s đã tồn tại</error>", $data['name']));
            }
            return 0;
        }
        try {
            if (isset($this->info['taxonomy']) && is_array($this->info['taxonomy'])) {
                foreach ($this->info['taxonomy'] as $taxonomy => $taxonomy_data) {
                    if (!empty($taxonomy_data) && is_array($taxonomy_data)) {
                        $taxonomy_data = array_filter($taxonomy_data);

                        if (!is_int($manga_id)) {
                            print_r($manga_id);
                            exit();
                        }
                        Taxonomy::SetTaxonomy($taxonomy, $taxonomy_data, $manga_id);
                    }
                }
            }

        } catch (Exception $e) {

            //Xử lý ngoại lệ ở đây
            print_r($this->info);
        }

        return $manga_id;
    }

}