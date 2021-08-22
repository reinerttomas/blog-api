<?php
declare(strict_types=1);

namespace App\Command\Blog\User;

use App\Command\ArgumentTrait;
use App\Command\CommandTrait;
use Blog\Core\StopWatch\StopWatch;
use Blog\Services\UserService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

final class UserCreateCommand extends Command
{
    use CommandTrait;
    use ArgumentTrait;

    protected static $defaultName = 'blog:user:create';
    protected static $defaultDescription = 'Vytvoreni uzivatele';

    private LoggerInterface $logger;
    private UserService $userService;

    public function __construct(
        LoggerInterface $logger,
        UserService $userService,
    ) {
        parent::__construct();

        $this->logger = $logger;
        $this->userService = $userService;
    }

    protected function configure(): void
    {
        $this->setName($this->defaultName())
            ->setDescription($this->defaultDescription())
            ->setHelp($this->defaultDescription())
            ->addArgument('email', InputArgument::REQUIRED)
            ->addArgument('username', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::REQUIRED)
            ->addArgument('name', InputArgument::REQUIRED)
            ->addArgument('surname', InputArgument::REQUIRED);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->askForArguments($input, $output, $this->io);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopWatch = new StopWatch();
        $stopWatch->start($this->defaultName());

        /** @var string $email */
        $email = $input->getArgument('email');
        /** @var string $username */
        $username = $input->getArgument('username');
        /** @var string $password */
        $password = $input->getArgument('password');
        /** @var string $name */
        $name = $input->getArgument('name');
        /** @var string $surname */
        $surname = $input->getArgument('surname');

        try {
            $user = $this->userService->createFromCommand(
                $email,
                $username,
                $password,
                $name,
                $surname,
            );

            $output->writeln('Email: ' . $user->getEmail());
            $output->writeln('Username: ' . $user->getUsername());
            $output->writeln('Password: ' . $user->getPassword());
            $output->writeln('Name: ' . $user->getName());
            $output->writeln('Surname: ' . $user->getSurname());
        } catch (Throwable $t) {
            $this->io->newLine(2);
            $this->io->error('Error:' . $t->getMessage());
            $this->logger->critical($t->getMessage(), $t->getTrace());
        }

        $this->io->newLine(2);
        $this->io->success('OK');
        $this->io->text($stopWatch->stop($this->defaultName())->getDurationMemoryMessage());

        return $this->success();
    }
}
