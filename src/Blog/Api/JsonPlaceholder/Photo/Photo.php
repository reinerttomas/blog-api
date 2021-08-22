<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Photo;

use ReinertTomas\JsonPlaceholderApi\Photo\Photo as PhotoApi;

class Photo
{
    private PhotoApi $photoApi;

    public function __construct(PhotoApi $photoApi)
    {
        $this->photoApi = $photoApi;
    }

    public function get(int $id): PhotoResponse
    {
        $response = $this->photoApi->get($id);

        return new PhotoResponse($response);
    }

    public function list(): array
    {
        /** @var array<int, PhotoResponse> $photos */
        $photos = [];

        $responses = $this->photoApi->list();

        foreach ($responses as $response) {
            $photos[] = new PhotoResponse($response);
        }

        return $photos;
    }
}
