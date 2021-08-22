<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @mixin Command
 */
trait CommandTrait
{
    protected SymfonyStyle $io;

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title($this->defaultDescription());
    }

    protected function configure(): void
    {
        $this->setName($this->defaultName())
            ->setDescription($this->defaultDescription())
            ->setHelp($this->defaultDescription());
    }

    protected function defaultName(): string
    {
        return (string)self::$defaultName;
    }

    protected function defaultDescription(): string
    {
        return (string)self::$defaultDescription;
    }

    protected function success(): int
    {
        return Command::SUCCESS;
    }

    protected function failure(): int
    {
        return Command::FAILURE;
    }

    protected function invalid(): int
    {
        return Command::INVALID;
    }
}
