<?php
declare(strict_types=1);

namespace Blog\Business;

use Blog\Api\JsonPlaceholder\Post\PostResponse;
use Blog\Dto\PostRequestDto;
use Blog\Entity\Post;
use Blog\Repository\PostRepository;

class PostBusiness
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function createFromRequest(PostRequestDto $postRequestDto): Post
    {
        return $this->create(
            $postRequestDto->getTitle(),
            $postRequestDto->getContent()
        );
    }

    public function createFromApi(PostResponse $postResponse): Post
    {
        return $this->create(
            $postResponse->getTitle(),
            $postResponse->getBody()
        );
    }

    private function create(
        string $title,
        string $content
    ): Post {
        $post = new Post(
            $title,
            $content
        );

        return $this->postRepository->store($post);
    }
}
