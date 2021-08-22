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

    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function getByEmail(string $email): User
    {
        $entity = $this->findByEmail($email);

        if ($entity === null) {
            throw new NotFoundException('User not found. Email: ' . $email);
        }

        return $entity;
    }

    public function findByUsername(string $username): ?User
    {
        return $this->findOneBy(['username' => $username]);
    }

    public function getByUsername(string $username): User
    {
        $entity = $this->findByUsername($username);

        if ($entity === null) {
            throw new NotFoundException('User not found. Username: ' . $username);
        }

        return $entity;
    }

    public function findByRemoteId(int $remoteId): ?User
    {
        return $this->findOneBy(['remoteId' => $remoteId]);
    }

    public function getByRemoteId(int $remoteId): User
    {
        $entity = $this->findByRemoteId($remoteId);

        if ($entity === null) {
            throw new NotFoundException('User not found. RemoteId: ' . $remoteId);
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
