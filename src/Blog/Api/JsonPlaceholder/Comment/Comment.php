<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Comment;

use ReinertTomas\JsonPlaceholderApi\Comment\Comment as CommentApi;

class Comment
{
    private CommentApi $commentApi;

    public function __construct(CommentApi $commentApi)
    {
        $this->commentApi = $commentApi;
    }

    public function get(int $id): CommentResponse
    {
        $response = $this->commentApi->get($id);

        return new CommentResponse($response);
    }

    public function list(): array
    {
        /** @var array<int, CommentResponse> $comments */
        $comments = [];

        $responses = $this->commentApi->list();

        foreach ($responses as $response) {
            $comments[] = new CommentResponse($response);
        }

        return $comments;
    }
}
