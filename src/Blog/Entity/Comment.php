<?php
declare(strict_types=1);

namespace Blog\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Blog\Core\DateTime;

#[ApiResource]
class Comment
{
    private int $id;
    private Post $post;
    private string $content;
    private ?int $remoteId;
    private DateTime $createdAt;
    private ?DateTime $updatedAt;
    private ?DateTime $syncAt;

    public function __construct(
        Post $post,
        string $content,
        ?int $remoteId,
        DateTime $createdAt,
        ?DateTime $updatedAt,
        ?DateTime $syncAt,
    ) {
        $this->post = $post;
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

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function changeContent(string $content): Comment
    {
        $this->content = $content;

        return $this;
    }

    public function getRemoteId(): ?int
    {
        return $this->remoteId;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function updated(): Comment
    {
        $this->updatedAt = new DateTime();

        return $this;
    }

    public function getSyncAt(): ?DateTime
    {
        return $this->syncAt;
    }

    public function changeSyncAt(?DateTime $syncAt): Comment
    {
        $this->syncAt = $syncAt;

        return $this;
    }
}
