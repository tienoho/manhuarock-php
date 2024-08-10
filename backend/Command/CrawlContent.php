<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputOption;

use Models\Chapter;


class CrawlContent extends Command
{
    use LockableTrait;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'crawl:content';

    protected function configure(): void
    {
        $this->setDescription('Crawl Content Chapter.');
        $this->setHelp('Crawl Content Chapter.');

        $this->addArgument('site', InputArgument::OPTIONAL, 'Site You Want To Crawl');
        $this->addArgument('save', InputArgument::OPTIONAL, 'If Not Save Image Set 0', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $site = $input->getArgument('site');
        $save = $input->getArgument('save');

        if (!$site) {
            if (!$this->lock()) {
                $output->writeln('The command is already running in another process.');
                return Command::SUCCESS;
            }

            $limit = 1;
        } else {
            $limit = 1;
        }

        while (true):
            Chapter::getDB()->objectBuilder()->orderBy('chapter_data.id', 'DESC');
            Chapter::getDB()->where('chapter_data.type', 'leech');
            Chapter::getDB()->where('chapter_data.used', 0);

            Chapter::getDB()->join('chapters', 'chapters.id=chapter_data.chapter_id');
            Chapter::getDB()->join('mangas', 'chapters.manga_id=mangas.id');

            if ($site) {
                Chapter::getDB()->where('chapter_data.storage', $site);
            }

            $data = Chapter::getDB()->objectBuilder()->get('chapter_data', $limit, 'chapter_data.id, chapter_data.content, chapter_data.storage, mangas.id as manga_id, chapter_data.chapter_id');

            if (empty($data)) {
                return Command::SUCCESS;
            }

            foreach ($data as $chapter) {
                // Bật cái này nếu leech đa luồng
                Chapter::getDB()->where('type', 'leech');
                Chapter::getDB()->where('id', $chapter->id)->update('chapter_data', [
                    'used' => 1
                ]);

                $url = $chapter->content;

                if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
                    $output->writeln(sprintf("URL is invalid: %s", $url));
                    Chapter::getDB()->where('id', $chapter->id)->update('chapter_data', [
                        'used' => 0
                    ]);
                    continue;
                }

                $storage = '\\Crawler\\' . $chapter->storage;
                $crawler = new $storage;

                $data_chapter = $crawler->content($url);

                $chapter->content = $data_chapter['content'];
                $chapter->type = $data_chapter['type'];
                if (empty($chapter->content)) {
                    Chapter::getDB()->where('id', $chapter->id)->update('chapter_data', [
                        'used' => 0
                    ]);
                    continue;
                }

                if ($chapter->type === 'image') {
                    if ($save === 1) {
                        $free_space = round(disk_free_space(ROOT_PATH . '/public/uploads/manga') / 1024 / 1024 / 1024);
                        if ($free_space <= 5) {
                            $output->writeln('Bộ nhớ trống ít nhất 2gb trở lên');
                            return Command::FAILURE;
                        }

                        $output->writeln("Bộ nhớ trống: $free_space GB");
                        $output->writeln("Bắt đầu lưu: $url");

                        $image_num = 0;

                        if (!$chapter->content) {
                            Chapter::getDB()->where('id', $chapter->id)->update('chapter_data', [
                                'used' => 0
                            ]);
                            continue;
                        }
                        $total = count($chapter->content);

                        $chap_content = [];
                        foreach ($chapter->content as $key => $image_url) {
                            $image_path = "manga/$chapter->manga_id/$chapter->chapter_id/$image_num.jpg";

                            $image_data = $crawler->curl($image_url);

                            if (isset($data_chapter['scramble'])) {
                                $ex = explode('/', $image_url);
                                $photo_id = str_replace('.jpg', '', end($ex));

                                $slice = get_slice($data_chapter['chapter_id'], $photo_id);
                                $image_data = build_image($image_data, $slice);
                            }

                            $image_url = (new \Services\Local())->upload($image_data, $image_path);
                            if (!$image_url) {
                                $output->writeln($image_data);
                                $this->release();
                                Chapter::getDB()->where('id', $chapter->id)->update('chapter_data', [
                                    'used' => 0
                                ]);
                                exit();
                            }

                            $chap_content[] = $image_url;
                            $output->writeln("[$image_num/$total] " . $image_url);
                            $image_num++;
                        }
                    }

                    $chap_content = json_encode($chap_content);
                } else {
                    $chap_content = $chapter->content;
                }

                Chapter::getDB()->where('id', $chapter->id)->update('chapter_data', [
                    'content' => $chap_content,
                    'type' => $chapter->type,
                    'used' => 0,
                    'storage_name' => 'Local'
                ]);

                $output->writeln(sprintf("Crawled: %s", $url));
            }

        endwhile;
    }
}