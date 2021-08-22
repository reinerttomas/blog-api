<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Comment;

use JetBrains\PhpStorm\Pure;
use ReinertTomas\JsonPlaceholderApi\Comment\CommentResponse as CommentResponseApi;

class CommentResponse
{
    private int $id;
    private int $postId;
    private string $name;
    private string $email;
    private string $body;

    #[Pure]
    public function __construct(CommentResponseApi $commentResponse)
    {
        $this->id = $commentResponse->getId();
        $this->postId = $commentResponse->getPostId();
        $this->name = $commentResponse->getName();
        $this->email = $commentResponse->getEmail();
        $this->body = $commentResponse->getBody();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
