<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Album;

use JetBrains\PhpStorm\Pure;
use ReinertTomas\JsonPlaceholderApi\Album\AlbumResponse as AlbumResponseApi;

class AlbumResponse
{
    private int $id;
    private int $userId;
    private string $title;

    #[Pure]
    public function __construct(AlbumResponseApi $albumResponse)
    {
        $this->id = $albumResponse->getId();
        $this->userId = $albumResponse->getUserId();
        $this->title = $albumResponse->getTitle();
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
}
