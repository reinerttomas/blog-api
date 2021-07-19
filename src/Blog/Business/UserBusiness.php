<?php
declare(strict_types=1);

namespace Blog\Business;

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
        );
    }

    private function create(
        string $email,
        string $username,
        string $password,
        string $name,
        string $surname,
    ): User {
        $user = new User(
            $email,
            $username,
            $password,
            $name,
            $surname,
        );

        return $this->userRepository->store($user);
    }

    private function update(
        User $user,
        string $email,
        string $username,
        string $password,
        string $name,
        string $surname,
    ): User {
        $user->changeEmail($email)
            ->changeUsername($username)
            ->changePassword($password)
            ->changeName($name, $surname)
            ->updated();

        return $this->userRepository->store($user);
    }
}
