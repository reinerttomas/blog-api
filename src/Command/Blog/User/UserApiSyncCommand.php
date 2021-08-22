<?php
declare(strict_types=1);

namespace App\Command\Blog\User;

use App\Command\CommandTrait;
use Blog\Api\JsonPlaceholder\JsonPlaceholderApi;
use Blog\Core\DateTime;
use Blog\Core\StopWatch\StopWatch;
use Blog\Services\UserService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class UserApiSyncCommand extends Command
{
    use CommandTrait;

    protected static $defaultName = 'blog:user:api:sync';
    protected static $defaultDescription = 'Synchronizace uživatelů z externího API';

    private LoggerInterface $logger;
    private UserService $userService;
    private JsonPlaceholderApi $jsonPlaceholderApi;

    public function __construct(
        LoggerInterface $logger,
        UserService $userService,
        JsonPlaceholderApi $jsonPlaceholderApi,
    ) {
        parent::__construct();

        $this->logger = $logger;
        $this->userService = $userService;
        $this->jsonPlaceholderApi = $jsonPlaceholderApi;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopWatch = new StopWatch();
        $stopWatch->start($this->defaultName());

        $progressBar = new ProgressBar($output);
        $progressBar->start();

        $syncAt = new DateTime();

        $userResponses = $this->jsonPlaceholderApi
            ->user()
            ->list();

        foreach ($userResponses as $userResponse) {
            try {
                $this->userService->updateOrCreateFromApi($userResponse, $syncAt);
            } catch (Throwable $t) {
                $this->io->newLine(2);
                $this->io->error('Error user: ' . $userResponse->getId());
                $this->logger->error($t->getMessage(), $t->getTrace());
            }

            $progressBar->advance();
        }

        $progressBar->finish();

        $this->io->newLine(2);
        $this->io->success('OK');
        $this->io->text($stopWatch->stop($this->defaultName())->getDurationMemoryMessage());

        return $this->success();
    }
}
