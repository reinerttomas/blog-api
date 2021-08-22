<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder;

use Blog\Api\JsonPlaceholder\Album\Album;
use Blog\Api\JsonPlaceholder\Comment\Comment;
use Blog\Api\JsonPlaceholder\Photo\Photo;
use Blog\Api\JsonPlaceholder\Post\Post;
use Blog\Api\JsonPlaceholder\Todo\Todo;
use Blog\Api\JsonPlaceholder\User\User;
use JetBrains\PhpStorm\Pure;
use ReinertTomas\JsonPlaceholderApi\JsonPlaceholderApi as JsonPlaceholderApiVendor;

class JsonPlaceholderApi
{
    private JsonPlaceholderApiVendor $jsonPlaceholderApi;

    #[Pure]
    public function __construct(array $config)
    {
        $this->jsonPlaceholderApi = new JsonPlaceholderApiVendor($config);
    }

    #[Pure]
    public function album(): Album
    {
        return new Album($this->jsonPlaceholderApi->album());
    }

    #[Pure]
    public function comment(): Comment
    {
        return new Comment($this->jsonPlaceholderApi->comment());
    }

    #[Pure]
    public function photo(): Photo
    {
        return new Photo($this->jsonPlaceholderApi->photo());
    }

    #[Pure]
    public function post(): Post
    {
        return new Post($this->jsonPlaceholderApi->post());
    }

    #[Pure]
    public function todo(): Todo
    {
        return new Todo($this->jsonPlaceholderApi->todo());
    }

    #[Pure]
    public function user(): User
    {
        return new User($this->jsonPlaceholderApi->user());
    }
}
