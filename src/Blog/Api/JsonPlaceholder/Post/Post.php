<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Post;

use ReinertTomas\JsonPlaceholderApi\Post\Post as PostApi;

class Post
{
    private PostApi $postApi;

    public function __construct(PostApi $postApi)
    {
        $this->postApi = $postApi;
    }

    public function get(int $id): PostResponse
    {
        $response = $this->postApi->get($id);

        return new PostResponse($response);
    }

    public function list(): array
    {
        /** @var array<int, PostResponse> $posts */
        $posts = [];

        $responses = $this->postApi->list();

        foreach ($responses as $response) {
            $posts[] = new PostResponse($response);
        }

        return $posts;
    }
}
