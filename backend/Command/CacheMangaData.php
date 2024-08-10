<?php

namespace Command;

use Models\Chapter;
use Models\Taxonomy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Models\Model;
use Services\Cache;

class CacheMangaData extends Command
{
    use LockableTrait;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'cache:manga_data';

    protected function configure(): void
    {
        $this->setDescription('Set manga data to cache.');
        $this->setHelp('Set manga data to cache.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');
            return Command::SUCCESS;
        }

        array_map('unlink', array_filter((array) glob(ROOT_PATH . '/data/manga-info/*')));

        Model::getDB()->orderBy("id");
        $mangas = Model::getDB()->objectBuilder()->get('mangas', null, 'id');

        foreach ($mangas as $manga) {
            $Chapters = Chapter::ChapterListByID($manga->id, 3);
            $Taxonomys = Taxonomy::GetALLTaxonomyManga($manga->id);

            set_manga_data('chapters', $manga->id, $Chapters);

            foreach ($Taxonomys as $taxonomy => $data) {
                set_manga_data($taxonomy, $manga->id, $data);
            }

            $output->writeln("Done ID: $manga->id");
        }


        return Command::SUCCESS;
    }
}
