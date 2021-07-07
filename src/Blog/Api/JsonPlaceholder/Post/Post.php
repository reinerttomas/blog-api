<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Post;

use Blog\Api\JsonPlaceholder\JsonPlaceholderClient;
use Blog\Exception\Exception;

class Post
{
    private const ENDPOINT = '/posts';

    private JsonPlaceholderClient $httpClient;

    public function __construct(JsonPlaceholderClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function get(int $id)
    {
        $response = $this->httpClient->get(self::ENDPOINT . '/' . $id);

        if ($response->getStatusCode() !== 200) {
            throw new Exception(
                sprintf('Error get post %d. Status code %d', $id, $response->getStatusCode())
            );
        }

        return new PostResponse($response->toArray());
    }

    public function list(): array
    {
        /** @var array<int, PostResponse> $postResponses */
        $postResponses = [];

        $response = $this->httpClient->get(self::ENDPOINT);

        if ($response->getStatusCode() !== 200) {
            throw new Exception(
                sprintf('Error get post %d. Status code %d', $id, $response->getStatusCode())
            );
        }

        $postsArray = $response->toArray();

        foreach ($postsArray as $postArray) {
            $postResponses[] = new PostResponse($postArray);
        }

        return $postResponses;
    }
}