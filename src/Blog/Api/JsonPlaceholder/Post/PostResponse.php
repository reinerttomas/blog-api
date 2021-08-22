<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Post;

use JetBrains\PhpStorm\Pure;
use ReinertTomas\JsonPlaceholderApi\Post\PostResponse as PostResponseApi;

class PostResponse
{
    private int $id;
    private int $userId;
    private string $title;
    private string $body;

    #[Pure]
    public function __construct(PostResponseApi $postResponse)
    {
        $this->id = $postResponse->getId();
        $this->userId = $postResponse->getUserId();
        $this->title = $postResponse->getTitle();
        $this->body = $postResponse->getBody();
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

    public function getBody(): string
    {
        return $this->body;
    }
}
