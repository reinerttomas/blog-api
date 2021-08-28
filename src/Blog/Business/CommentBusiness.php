<?php
declare(strict_types=1);

namespace Blog\Business;

use Blog\Api\JsonPlaceholder\Comment\CommentResponse;
use Blog\Core\DateTime;
use Blog\Entity\Comment;
use Blog\Entity\Post;
use Blog\Repository\CommentRepository;
use Blog\Repository\PostRepository;

class CommentBusiness
{
    private CommentRepository $commentRepository;
    private PostRepository $postRepository;

    public function __construct(
        CommentRepository $commentRepository,
        PostRepository $postRepository,
    ) {
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
    }

    public function updateOrCreate(CommentResponse $commentResponse, DateTime $syncAt): Comment
    {
        $comment = $this->commentRepository->findByRemoteId($commentResponse->getId());

        if ($comment === null) {
            $comment = $this->createFromApi($commentResponse, $syncAt);
        } else {
            $comment = $this->updateFromApi($comment, $commentResponse, $syncAt);
        }

        return $comment;
    }

    private function createFromApi(
        CommentResponse $commentResponse,
        DateTime $syncAt,
    ): Comment {
        $post = $this->postRepository->getByRemoteId($commentResponse->getPostId());

        return $this->create(
            $post,
            $commentResponse->getBody(),
            $commentResponse->getId(),
            new DateTime(),
            null,
            $syncAt,
        );
    }

    private function updateFromApi(
        Comment $comment,
        CommentResponse $commentResponse,
        DateTime $syncAt,
    ): Comment {
        return $this->update(
            $comment,
            $commentResponse->getBody(),
            $syncAt,
        );
    }

    private function create(
        Post $post,
        string $content,
        ?int $remoteId,
        DateTime $createdAt,
        ?DateTime $updatedAt,
        ?DateTime $syncAt,
    ): Comment {
        $comment = new Comment(
            $post,
            $content,
            $remoteId,
            $createdAt,
            $updatedAt,
            $syncAt,
        );

        return $this->commentRepository->store($comment);
    }

    private function update(
        Comment $comment,
        string $content,
        ?DateTime $syncAt,
    ): Comment {
        $comment->updated()
            ->changeContent($content)
            ->changeSyncAt($syncAt);

        return $this->commentRepository->store($comment);
    }
}
