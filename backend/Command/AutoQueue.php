<?php

namespace Command;

use Models\Model;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AutoQueue extends Command
{
    use LockableTrait;

    protected static $defaultName = 'auto:queue';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock(date('i'))) {
            $output->writeln('The command is already running in another process.');
            return Command::SUCCESS;
        }

        $queues = Model::getDB()->objectBuilder()->where('running', 0)->get('crawl_queue');
        $command = $this->getApplication()->find('auto:manga');


        if ($queues) {
            foreach ($queues as $queue) {
                Model::getDB()->where('id', $queue->id)->update('crawl_queue', ['running' => 1]);

                try {
                    $arguments = [
                        'source' => $queue->source, 
                        '--link' => $queue->url
                    ];

                    $AutoMangaInput = new ArrayInput($arguments);
                    $command->run($AutoMangaInput, $output);
                } finally {
                    Model::getDB()->where('id', $queue->id)->delete('crawl_queue');
                }
     
            }

        }

        $this->release();
        return Command::SUCCESS;
    }
}