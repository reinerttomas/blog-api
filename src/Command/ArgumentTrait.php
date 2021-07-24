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
trait ArgumentTrait
{
    public function askForArguments(
        InputInterface $input,
        OutputInterface $output,
        SymfonyStyle $io,
    ): void {
        foreach ($input->getArguments() as $option => $value) {
            if ($value === null) {
                $input->setArgument($option, $io->ask(sprintf('%s', ucfirst($option))));
            }
        }
    }
}
