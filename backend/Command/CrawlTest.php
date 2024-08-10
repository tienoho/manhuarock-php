<?php

namespace Command;

use Google\Service\ShoppingContent\Service;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlTest extends Command
{
    protected static $defaultName = 'test';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $autoManga = new \Services\AutoManga();

        $autoManga->setCrawler(new \Crawler\Truyenqq());

        $autoManga->saveManga('https://truyenqqviet.com/truyen-tranh/nghich-do-moi-ngay-deu-muon-bat-nat-su-phu-12642');
        
        return Command::SUCCESS;
    }
}
