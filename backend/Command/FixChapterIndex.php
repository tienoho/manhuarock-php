<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Models\Chapter;


class FixChapterIndex extends Command
{
    use LockableTrait;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'fix:chapter_index';

    protected function configure(): void
    {
        $this->setDescription('Fix Chapter Index.');
        $this->setHelp('Fix Chapter Index.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');
            return Command::SUCCESS;
        }

        $output->writeln('Bắt đầu lấy danh sách chương');


        $data = Chapter::getDB()->objectBuilder()->orderBy('id')->get('chapters', 100, 'id, name');

        if (empty($data)) {
            return Command::SUCCESS;
        }

        foreach ($data as $chapter) {
            if(preg_match('#(chapter|chương|chap)(.[\d.]+)#is', $chapter->name, $name) || preg_match('#([C]+)([\d.]+)#is', $chapter->name, $name)) {

                if(isset($name[2]) && is_numeric($name[2])){
                    Chapter::getDB()->where('id', $chapter->id)->update('chapters', [
                           'name' => 'Chapter '. trim($name[2]),
                           'chapter_index' => trim($name[2])
                        ]
                    );
                    $output->writeln(sprintf("Fix: %s to %s", $chapter->name, $name[2]));
                    continue;
                }
            }

            if(is_numeric($chapter->name)){
                Chapter::getDB()->where('id', $chapter->id)->update('chapters', [
                        'name' => 'Chapter '. trim($chapter->name),
                        'chapter_index' => trim($chapter->name)
                    ]
                );

                $output->writeln(sprintf("Fix: %s", $chapter->name));

            }
        }

        return Command::SUCCESS;
    }
}