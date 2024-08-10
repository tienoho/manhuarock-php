<?php

namespace Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Services\Cache;

class CacheClear extends Command
{
    use LockableTrait;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'cache:clear';

    protected function configure(): void
    {
        $this->setDescription('Set manga data to cache.');
        $this->setHelp('Set manga data to cache.');
    }

    /**
     * @throws \Symfony\Component\Console\Exception\ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $cache = (new Cache())->load();
        $cache->clear();

        $command = $this->getApplication()->find('cache:manga_data');
        $command->run(new ArrayInput([]), $output);

        return Command::SUCCESS;
    }
}