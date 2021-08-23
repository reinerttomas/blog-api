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
    private User $author;
    private string $slug;
    private string $title;
    private string $content;
    private ?int $remoteId;
    private DateTime $createdAt;
    private ?DateTime $updatedAt;
    private ?DateTime $syncAt;

    public function __construct(
        User $author,
        string $title,
        string $content,
        ?int $remoteId,
        DateTime $createdAt,
        ?DateTime $updatedAt,
        ?DateTime $syncAt,
    ) {
        $this->author = $author;
        $this->changeTitle($title);
        $this->content = $content;
        $this->remoteId = $remoteId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->syncAt = $syncAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function changeAuthor(User $author): Post
    {
        $this->author = $author;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function changeTitle(string $title): Post
    {
        $this->slug = Strings::webalize($title);
        $this->title = $title;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getRemoteId(): ?int
    {
        return $this->remoteId;
    }

    public function changeContent(string $content): Post
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function updated(): Post
    {
        $this->updatedAt = new DateTime();

        return $this;
    }

    public function getSyncAt(): ?DateTime
    {
        return $this->syncAt;
    }

    public function changeSyncAt(?DateTime $syncAt): Post
    {
        $this->syncAt = $syncAt;

        return $this;
    }
}
