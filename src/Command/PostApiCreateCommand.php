<?php
declare(strict_types=1);

namespace App\Command;

use Blog\Api\JsonPlaceholder\JsonPlaceholderApi;
use Blog\Core\StopWatch\StopWatch;
use Blog\Services\PostService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

class PostApiCreateCommand extends Command
{
    protected static $defaultName = 'blog:post-api:create';
    protected static $defaultDescription = 'Vytvoreni clanku z API';

    private SymfonyStyle $io;

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

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopWatch = new StopWatch();
        $stopWatch->start($this->defaultName());

        $progressBar = new ProgressBar($output);
        $progressBar->start();

        $postResponses = $this->jsonPlaceholderApi
            ->post()
            ->list();

        foreach ($postResponses as $postResponse) {
            try {
                $this->postService->createFromJsonPlaceholderApi($postResponse);
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

        return Command::SUCCESS;
    }

    private function defaultName(): string
    {
        return (string)self::$defaultName;
    }

    private function defaultDescription(): string
    {
        return (string)self::$defaultDescription;
    }
}
