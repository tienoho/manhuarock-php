<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Models\Model;


class AutoResetView extends Command
{
    use LockableTrait;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:resetview';

    protected function configure(): void
    {
        $this->addArgument('type', InputArgument::REQUIRED, 'd|w|m');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getArgument('type');

        switch ($type) {
            case 'd':
                $update = ['views_day' => 0];
                break;
            case 'w':
                $update = ['views_week' => 0];
                break;
            case 'm':
                $update = ['views_month' => 0];
                break;
        }

        Model::getDB()->update('mangas', $update);

        return Command::SUCCESS;
    }
}