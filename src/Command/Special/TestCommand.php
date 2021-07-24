<?php
declare(strict_types=1);

namespace App\Command\Special;

use App\Command\ArgumentTrait;
use App\Command\DescriptionTrait;
use Blog\Core\StopWatch\StopWatch;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestCommand extends Command
{
    use DescriptionTrait;
    use ArgumentTrait;

    protected static $defaultName = 'special:test:test';
    protected static $defaultDescription = 'Test';

    private SymfonyStyle $io;

    protected function configure(): void
    {
        $this->setName($this->defaultName())
            ->setDescription($this->defaultDescription())
            ->setHelp($this->defaultDescription())
            ->addArgument('argument', InputArgument::REQUIRED)
            ->addOption('option', null);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title($this->defaultDescription());
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->askForArguments($input, $output, $this->io);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string|null $argument */
        $argument = $input->getArgument('argument');

        /** @var string|null $option */
        $option = $input->getOption('option');

        $stopWatch = new StopWatch();
        $stopWatch->start($this->defaultName());
        sleep(1);
        $this->io->success('OK');
        $this->io->success('Argument: ' . $argument);
        $this->io->success('Option: ' . $option);

        $this->io->text($stopWatch->stop($this->defaultName())->getDurationMemoryMessage());

        return Command::SUCCESS;
    }
}
