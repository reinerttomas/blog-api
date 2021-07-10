<?php
declare(strict_types=1);

namespace Blog\Entity;

use Blog\Core\DateTime;
use Blog\Core\Strings;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class Post implements JsonSerializable
{
    private int $id;
    private string $slug;
    private string $title;
    private string $content;
    private DateTime $createdAt;

    public function __construct(
        string $title,
        string $content
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

    #[ArrayShape(
        [
            'id' => "int",
            'slug' => "string",
            'title' => "string",
            'content' => "string",
            'createdAt' => "string"
        ]
    )]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'content' => $this->content,
            'createdAt' => $this->createdAt->format(DATE_ATOM),
        ];
    }
}
