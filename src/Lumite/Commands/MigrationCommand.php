<?php
namespace Lumite\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Lumite\Migrations\MigrationRunner;

class MigrationCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('migrate')
            ->setDescription('Run all pending migrations.')
            ->setHelp('This command runs all pending migrations.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $runner = new MigrationRunner();
        $runner->runAll($output);
        return Command::SUCCESS;
    }
}
