<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class CrawlCover extends Command {
    protected static $defaultName = 'crawl:covers';

    protected function configure(): void {
        $this->setDescription('Crawl covers');
        $this->setHelp('Crawl covers');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Truyen qq
        // import('Crawler/TruyenQQ');
        $crawler = new \Crawler\Goctruyenhay();
        $index = 0;

        while(true){
            $index++;
            $list = $crawler->list($index);

            if(empty($list)){
                break;
            }

            foreach ($list as $url){
                $info = $crawler->info($url);

                if(empty($info)){
                    continue;
                }

                $name = $info['name'];
                $cover = $info['cover'];

                if(empty($name) || empty($cover)){
                    continue;
                }

                $slug = slugGenerator($name);
                $cover = $crawler->bypass($cover);
                file_put_contents(ROOT_PATH . '/publish/uploads/covers/' . $slug . '.jpg', ($cover));

                $output->writeln($slug);
            }
        }

        return Command::SUCCESS;
    }

}