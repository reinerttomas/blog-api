<?php
declare(strict_types=1);

namespace Blog\Business;

use Blog\Api\JsonPlaceholder\Post\PostResponse;
use Blog\Core\DateTime;
use Blog\Dto\Api\PostRequestDto;
use Blog\Entity\Post;
use Blog\Entity\User;
use Blog\Repository\PostRepository;
use Blog\Repository\UserRepository;

class PostBusiness
{
    private PostRepository $postRepository;
    private UserRepository $userRepository;

    public function __construct(
        PostRepository $postRepository,
        UserRepository $userRepository,
    ) {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function createFromRequest(PostRequestDto $postRequestDto): Post
    {
        return $this->create(
            $postRequestDto->getAuthor(),
            $postRequestDto->getTitle(),
            $postRequestDto->getContent(),
            null,
            null,
        );
    }

    public function updateOrCreateFromApi(PostResponse $postResponse, DateTime $syncAt): Post
    {
        $post = $this->postRepository->findByRemoteId($postResponse->getId());
        $author = $this->userRepository->getByRemoteId($postResponse->getUserId());

        if ($post === null) {
            $post = $this->createFromApi(
                $author,
                $postResponse,
                $syncAt,
            );
        } else {
            $post = $this->updateFromApi(
                $post,
                $author,
                $postResponse,
                $syncAt,
            );
        }

        return $post;
    }

    public function updateFromApi(
        Post $post,
        User $author,
        PostResponse $postResponse,
        DateTime $syncAt,
    ): Post {
        return $this->update(
            $post,
            $author,
            $postResponse->getTitle(),
            $postResponse->getBody(),
            $syncAt,
        );
    }

    public function update(
        Post $post,
        User $author,
        string $title,
        string $content,
        ?DateTime $syncAt,
    ): Post {
        $post->changeAuthor($author)
            ->changeTitle($title)
            ->changeContent($content)
            ->changeSyncAt($syncAt)
            ->updated();

        return $this->postRepository->store($post);
    }

    private function createFromApi(
        User $author,
        PostResponse $postResponse,
        DateTime $syncAt,
    ): Post {
        return $this->create(
            $author,
            $postResponse->getTitle(),
            $postResponse->getBody(),
            $postResponse->getId(),
            $syncAt,
        );
    }

    private function create(
        User $author,
        string $title,
        string $content,
        ?int $remoteId,
        ?DateTime $syncAt,
    ): Post {
        $post = new Post(
            $author,
            $title,
            $content,
            $remoteId,
            new DateTime(),
            null,
            $syncAt,
        );

        return $this->postRepository->store($post);
    }
}
