<?php
declare(strict_types=1);

namespace Blog\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Blog\Core\DateTime;

#[ApiResource]
class Comment
{
    private int $id;
    private string $content;
    private DateTime $createdAt;
    private ?DateTime $updatedAt;

    public function __construct(
        string $content,
        DateTime $createdAt,
        ?DateTime $updatedAt,
    ) {
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function updated(): static
    {
        $this->updatedAt = new DateTime();

        return $this;
    }
}
