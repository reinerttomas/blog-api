<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Photo;

use JetBrains\PhpStorm\Pure;
use ReinertTomas\JsonPlaceholderApi\Photo\PhotoResponse as PhotoResponseApi;

class PhotoResponse
{
    private int $id;
    private int $albumId;
    private string $title;
    private string $url;
    private string $thumbnailUrl;

    #[Pure]
    public function __construct(PhotoResponseApi $photoResponse)
    {
        $this->id = $photoResponse->getId();
        $this->albumId = $photoResponse->getAlbumId();
        $this->title = $photoResponse->getTitle();
        $this->url = $photoResponse->getUrl();
        $this->thumbnailUrl = $photoResponse->getThumbnailUrl();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAlbumId(): int
    {
        return $this->albumId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getThumbnailUrl(): string
    {
        return $this->thumbnailUrl;
    }
}
