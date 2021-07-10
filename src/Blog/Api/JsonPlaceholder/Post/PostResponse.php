<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\Post;

use Blog\Core\Arrays;
use Blog\Core\Parser;

class PostResponse
{
    private int $id;
    private int $userId;
    private string $title;
    private string $body;

    public function __construct(array $data)
    {
        Arrays::checkIndexExists($data, 'id');
        Arrays::checkIndexExists($data, 'userId');
        Arrays::checkIndexExists($data, 'title');
        Arrays::checkIndexExists($data, 'body');

        $this->id = Parser::parseInt($data['id']);
        $this->userId = Parser::parseInt($data['userId']);
        $this->title = Parser::parseString($data['title']);
        $this->body = Parser::parseString($data['body']);
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

    public function getBody(): string
    {
        return $this->body;
    }
}
