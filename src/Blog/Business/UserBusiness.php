<?php
declare(strict_types=1);

namespace Blog\Business;

use Blog\Api\JsonPlaceholder\User\UserResponse;
use Blog\Core\DateTime;
use Blog\Core\Strings;
use Blog\Entity\User;
use Blog\Exception\ArgumentException;
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

    public function updateOrCreateFromApi(UserResponse $userResponse, DateTime $lastSyncAt): User
    {
        $nameArray = Strings::split($userResponse->getName(), '/[\s]+/');

        if (count($nameArray) < 0) {
            throw new ArgumentException(
                sprintf('Name %s is invalid for split.', $userResponse->getName()),
            );
        }

        [$name, $surname] = $nameArray;

        return $this->create(
            $userResponse->getEmail(),
            $userResponse->getUsername(),
            null,
            $name,
            $surname,
            $userResponse->getId(),
            $lastSyncAt,
        );
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
