<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Todo;

use ReinertTomas\JsonPlaceholderApi\Todo\Todo as TodoApi;

class Todo
{
    private TodoApi $todoApi;

    public function __construct(TodoApi $todoApi)
    {
        $this->todoApi = $todoApi;
    }

    public function get(int $id): TodoResponse
    {
        $response = $this->todoApi->get($id);

        return new TodoResponse($response);
    }

    public function list(): array
    {
        /** @var array<int, TodoResponse> $todos */
        $todos = [];

        $responses = $this->todoApi->list();

        foreach ($responses as $response) {
            $todos[] = new TodoResponse($response);
        }

        return $todos;
    }
}
