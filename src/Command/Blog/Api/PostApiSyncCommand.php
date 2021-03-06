<?php
declare(strict_types=1);

namespace App\Command\Blog\Api;

use App\Command\CommandTrait;
use Blog\Api\JsonPlaceholder\JsonPlaceholderApi;
use Blog\Core\DateTime;
use Blog\Core\StopWatch\StopWatch;
use Blog\Services\PostService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

final class PostApiSyncCommand extends Command
{
    use CommandTrait;

    protected static $defaultName = 'blog:api:post:sync';
    protected static $defaultDescription = 'Synchronizace článků z externího API';

    private LoggerInterface $logger;
    private PostService $postService;
    private JsonPlaceholderApi $jsonPlaceholderApi;

    public function __construct(
        LoggerInterface $logger,
        PostService $postService,
        JsonPlaceholderApi $jsonPlaceholderApi,
    ) {
        parent::__construct();

        $this->logger = $logger;
        $this->postService = $postService;
        $this->jsonPlaceholderApi = $jsonPlaceholderApi;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopWatch = new StopWatch();
        $stopWatch->start($this->defaultName());

        $progressBar = new ProgressBar($output);
        $progressBar->start();

        $syncAt = new DateTime();

        $postResponses = $this->jsonPlaceholderApi
            ->post()
            ->list();

        foreach ($postResponses as $postResponse) {
            try {
                $this->postService->updateOrCreateFromApi($postResponse, $syncAt);
            } catch (Throwable $t) {
                $this->io->newLine(2);
                $this->io->error('Error post: ' . $postResponse->getId());
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
