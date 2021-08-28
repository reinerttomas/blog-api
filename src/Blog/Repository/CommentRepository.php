<?php
declare(strict_types=1);

namespace Blog\Repository;

use Blog\Core\Paginator;
use Blog\Entity\Comment;
use Blog\Exception\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function list(Paginator $paginator): array
    {
        return $this->findBy(
            [],
            null,
            $paginator->getLimit(),
            $paginator->getOffset(),
        );
    }

    public function get(int $id): Comment
    {
        $entity = $this->find($id);

        if ($entity === null) {
            throw new NotFoundException('Comment not found. ID: ' . $id);
        }

        return $entity;
    }

    public function findByRemoteId(int $remoteId): ?Comment
    {
        return $this->findOneBy(['remoteId' => $remoteId]);
    }

    public function getByRemoteId(int $remoteId): Comment
    {
        $entity = $this->findByRemoteId($remoteId);

        if ($entity === null) {
            throw new NotFoundException('Comment not found. RemoteId: ' . $remoteId);
        }

        return $entity;
    }

    public function store(Comment $entity): Comment
    {
        $em = $this->getEntityManager();

        $em->persist($entity);
        $em->flush();

        return $entity;
    }
}
