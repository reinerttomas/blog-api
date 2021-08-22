<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Album;

use ReinertTomas\JsonPlaceholderApi\Album\Album as AlbumApi;

class Album
{
    private AlbumApi $albumApi;

    public function __construct(AlbumApi $albumApi)
    {
        $this->albumApi = $albumApi;
    }

    public function get(int $id): AlbumResponse
    {
        $response = $this->albumApi->get($id);

        return new AlbumResponse($response);
    }

    public function list(): array
    {
        /** @var array<int, AlbumResponse> $albums */
        $albums = [];

        $responses = $this->albumApi->list();

        foreach ($responses as $response) {
            $albums[] = new AlbumResponse($response);
        }

        return $albums;
    }
}
