<?php
declare(strict_types=1);

namespace Blog\Repository;

use Blog\Core\Paginator;
use Blog\Entity\User;
use Blog\Exception\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
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

    public function get(int $id): User
    {
        $entity = $this->find($id);

        if ($entity === null) {
            throw new NotFoundException('User not found. ID: ' . $id);
        }

        return $entity;
    }

    public function store(User $entity): User
    {
        $em = $this->getEntityManager();

        $em->persist($entity);
        $em->flush();

        return $entity;
    }
}
