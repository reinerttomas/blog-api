<?php
declare(strict_types=1);

namespace Blog\Dto\Api;

use Blog\Entity\User;

class PostRequestDto
{
    private User $author;
    private string $title;
    private string $content;

    public function __construct(
        User $author,
        string $title,
        string $content,
    ) {
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
