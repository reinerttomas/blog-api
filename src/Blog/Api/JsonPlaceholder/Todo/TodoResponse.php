<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Todo;

use JetBrains\PhpStorm\Pure;
use ReinertTomas\JsonPlaceholderApi\Todo\TodoResponse as TodoResponseApi;

class TodoResponse
{
    private int $id;
    private int $userId;
    private string $title;
    private bool $completed;

    #[Pure]
    public function __construct(TodoResponseApi $todoResponse)
    {
        $this->id = $todoResponse->getId();
        $this->userId = $todoResponse->getUserId();
        $this->title = $todoResponse->getTitle();
        $this->completed = $todoResponse->isCompleted();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }
}
