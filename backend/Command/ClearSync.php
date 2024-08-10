<?php

namespace Command;

use Models\Model;
use Services\Aws;
use Services\Backblaze;
use Services\Discord;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Filesystem\Filesystem;

use Models\Chapter;


class ClearSync extends Command
{
    use LockableTrait;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'crawl:clearsync';


    protected function configure(): void
    {
        $this->setDescription('Đồng Bộ Ảnh');
        $this->setHelp('Đồng Bộ Ảnh');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rootPath = ROOT_PATH . '/public/uploads/manga';

        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');
            return Command::SUCCESS;
        }


        $mangaDirs = glob("$rootPath/*", GLOB_ONLYDIR);



        foreach ($mangaDirs as $mangaDir) {
            if(empty($mangaDir)){
                (new Filesystem)->remove($chapDir);
                continue;
            }

            $chapDirs = glob("$mangaDir/*", GLOB_ONLYDIR);
            foreach ($chapDirs as $chapDir) {

                $chapID = basename($chapDir);

                Model::getDB()->where('storage_name', 'Local', 'NOT LIKE');
                Model::getDB()->where('storage_name', 'Server 1', 'NOT LIKE');
                Model::getDB()->where('type', 'image');
                Model::getDB()->where('used', 0);
                Model::getDB()->where('chapter_id', $chapID);

                if (!Model::getDB()->has('chapter_data')) {
//                    $output->writeln("Chưa đồng bộ $chapDir");
//
//                    $output->writeln("+--------------------------------------+");

                    continue;
                }


                (new Filesystem)->remove($chapDir);
                $output->writeln("Đã xoá $chapDir");

                $output->writeln("+--------------------------------------+");

            }
        }


        return Command::SUCCESS;
    }
}