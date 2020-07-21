<?php


namespace App\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetRateCommand extends Command
{
    protected static $defaultName = 'app:get-rate';

    protected function configure()
    {
        $this
            ->setDescription('')
            ->setHelp('')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
        $output->writeln('');
        return 0;
    }

}