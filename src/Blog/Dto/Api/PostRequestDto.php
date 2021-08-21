<?php
declare(strict_types=1);

namespace Blog\Dto\Api;

use Blog\Entity\User;

class PostRequestDto
{
    private User $user;
    private string $title;
    private string $content;

    public function __construct(
        User $user,
        string $title,
        string $content,
    ) {
        $this->user = $user;
        $this->title = $title;
        $this->content = $content;
    }

    public function getUser(): User
    {
        return $this->user;
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
