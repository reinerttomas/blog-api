<?php
declare(strict_types=1);

namespace App\Command\Blog\Api;

use App\Command\CommandTrait;
use Blog\Api\JsonPlaceholder\JsonPlaceholderApi;
use Blog\Core\DateTime;
use Blog\Core\StopWatch\StopWatch;
use Blog\Services\CommentService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class CommentApiSyncCommand extends Command
{
    use CommandTrait;

    protected static $defaultName = 'blog:api:comment:sync';
    protected static $defaultDescription = 'Synchronizace komentářů z externího API';

    private LoggerInterface $logger;
    private CommentService $commentService;
    private JsonPlaceholderApi $jsonPlaceholderApi;

    public function __construct(
        LoggerInterface $logger,
        CommentService $commentService,
        JsonPlaceholderApi $jsonPlaceholderApi,
    ) {
        parent::__construct();

        $this->logger = $logger;
        $this->commentService = $commentService;
        $this->jsonPlaceholderApi = $jsonPlaceholderApi;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopWatch = new StopWatch();
        $stopWatch->start($this->defaultName());

        $progressBar = new ProgressBar($output);
        $progressBar->start();

        $syncAt = new DateTime();

        $commentResponses = $this->jsonPlaceholderApi
            ->comment()
            ->list();

        foreach ($commentResponses as $commentResponse) {
            try {
                $this->commentService->updateOrCreateFromApi($commentResponse, $syncAt);
            } catch (Throwable $t) {
                $this->io->newLine(2);
                $this->io->error('Error comment: ' . $commentResponse->getId());
                $this->logger->critical($t->getMessage(), $t->getTrace());
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
