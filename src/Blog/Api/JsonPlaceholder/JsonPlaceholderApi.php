<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder;

use Blog\Api\JsonPlaceholder\Post\Post;
use JetBrains\PhpStorm\Pure;

class JsonPlaceholderApi
{
    private JsonPlaceholderClient $jsonPlaceholderClient;

    #[Pure]
    public function __construct(array $httpApiConfig)
    {
        $this->jsonPlaceholderClient = new JsonPlaceholderClient($httpApiConfig['base_uri']);
    }

    #[Pure]
    public function post(): Post
    {
        return new Post($this->jsonPlaceholderClient);
    }
}
