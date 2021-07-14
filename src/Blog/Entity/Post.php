<?php
declare(strict_types=1);

namespace Blog\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Blog\Core\DateTime;
use Blog\Core\Strings;

#[ApiResource]
class Post
{
    private int $id;
    private string $slug;
    private string $title;
    private string $content;
    private DateTime $createdAt;

    public function __construct(
        string $title,
        string $content,
    ) {
        $this->slug = Strings::webalize($title);
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
