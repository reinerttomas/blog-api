<?php
declare(strict_types=1);

namespace Blog\Services;

use Blog\Api\JsonPlaceholder\Post\PostResponse;
use Blog\Business\PostBusiness;
use Blog\Core\Paginator;
use Blog\Dto\PostRequestDto;
use Blog\Entity\Post;
use Blog\Repository\PostRepository;

class PostService
{
    private PostRepository $postRepository;
    private PostBusiness $postBusiness;

    public function __construct(
        PostRepository $postRepository,
        PostBusiness $postBusiness,
    ) {
        $this->postRepository = $postRepository;
        $this->postBusiness = $postBusiness;
    }

    public function list(Paginator $paginator): array
    {
        return $this->postRepository->list($paginator);
    }

    public function get(int $id): Post
    {
        return $this->postRepository->get($id);
    }

    public function getBySlug(string $slug): Post
    {
        return $this->postRepository->getBySlug($slug);
    }

    public function createFromRequest(PostRequestDto $postRequestDto): Post
    {
        return $this->postBusiness->createFromRequest($postRequestDto);
    }

    public function createFromJsonPlaceholderApi(PostResponse $postResponse): Post
    {
        return $this->postBusiness->createFromJsonPlaceholderApi($postResponse);
    }
}
