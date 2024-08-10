<?php

namespace Command;

use Models\Model;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReupCover extends Command
{
    protected static $defaultName = 'update_cover';

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $storage = getConf('upload-storage');
        $storage_driver = new $storage['driver'];

        $mangas = Model::getDB()->where('cover', '%goctruyenhay%', 'LIKE')->objectBuilder()->get('mangas');

        foreach ($mangas as $manga) {
            $images = (new \Crawler\Goctruyenhay())->bypass($manga->cover);

            $new_cover = $storage_driver->upload("covers/{$manga->slug}.jpg", $images);

            echo $new_cover . PHP_EOL;

            if ($new_cover) {
                Model::getDB()->where('id', $manga->id)->update('mangas', [
                    'cover' => $new_cover
                ]);
            }
        }


        return Command::SUCCESS;
    }
}
