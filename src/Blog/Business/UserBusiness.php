<?php
declare(strict_types=1);

namespace Blog\Business;

use Blog\Api\JsonPlaceholder\User\UserResponse;
use Blog\Core\DateTime;
use Blog\Entity\User;
use Blog\Repository\UserRepository;

class UserBusiness
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createFromCommand(
        string $email,
        string $username,
        string $password,
        string $name,
        string $surname,
    ): User {
        return $this->create(
            $email,
            $username,
            $password,
            $name,
            $surname,
            null,
            null,
        );
    }

    public function updateOrCreateFromApi(UserResponse $userResponse, DateTime $syncAt): User
    {
        $user = $this->userRepository->findByRemoteId($userResponse->getId());

        if ($user === null) {
            $user = $this->create(
                $userResponse->getEmail(),
                $userResponse->getUsername(),
                null,
                $userResponse->getName(),
                $userResponse->getSurname(),
                $userResponse->getId(),
                $syncAt,
            );
        } else {
            $user = $this->update(
                $user,
                $userResponse->getEmail(),
                $userResponse->getUsername(),
                null,
                $userResponse->getName(),
                $userResponse->getSurname(),
                $syncAt,
            );
        }

        return $user;
    }

    private function create(
        string $email,
        string $username,
        ?string $password,
        string $name,
        string $surname,
        ?int $remoteId,
        ?DateTime $syncAt,
    ): User {
        $user = new User(
            $email,
            $username,
            $password,
            $name,
            $surname,
            $remoteId,
            new DateTime(),
            null,
            $syncAt,
        );

        return $this->userRepository->store($user);
    }

    private function update(
        User $user,
        string $email,
        string $username,
        ?string $password,
        string $name,
        string $surname,
        ?DateTime $syncAt,
    ): User {
        $user->changeEmail($email)
            ->changeUsername($username)
            ->changePassword($password)
            ->changeName($name, $surname)
            ->changeSyncAt($syncAt)
            ->updated();

        return $this->userRepository->store($user);
    }
}
