<?php
declare(strict_types=1);

namespace Blog\Services;

use Blog\Api\JsonPlaceholder\Comment\CommentResponse;
use Blog\Business\CommentBusiness;
use Blog\Core\DateTime;
use Blog\Entity\Comment;
use Blog\Repository\CommentRepository;

class CommentService
{
    private CommentRepository $commentRepository;
    private CommentBusiness $commentBusiness;

    public function __construct(
        CommentRepository $commentRepository,
        CommentBusiness $commentBusiness,
    ) {
        $this->commentRepository = $commentRepository;
        $this->commentBusiness = $commentBusiness;
    }

    public function get(int $id): Comment
    {
        return $this->commentRepository->get($id);
    }

    public function updateOrCreateFromApi(CommentResponse $commentResponse, DateTime $syncAt): Comment
    {
        return $this->commentBusiness->updateOrCreate($commentResponse, $syncAt);
    }
}
