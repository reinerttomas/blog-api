<?php
declare(strict_types=1);

namespace Blog\Services;

use Blog\Api\JsonPlaceholder\User\UserResponse;
use Blog\Business\UserBusiness;
use Blog\Core\DateTime;
use Blog\Entity\User;
use Blog\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;
    private UserBusiness $userBusiness;

    public function __construct(
        UserRepository $userRepository,
        UserBusiness $userBusiness,
    ) {
        $this->userRepository = $userRepository;
        $this->userBusiness = $userBusiness;
    }

    public function get(int $id): User
    {
        return $this->userRepository->get($id);
    }

    public function createFromCommand(
        string $email,
        string $username,
        string $password,
        string $name,
        string $surname,
    ): User {
        return $this->userBusiness->createFromCommand(
            $email,
            $username,
            $password,
            $name,
            $surname,
        );
    }

    public function updateOrCreateFromApi(UserResponse $userResponse, DateTime $syncAt): User
    {
        return $this->userBusiness->updateOrCreateFromApi($userResponse, $syncAt);
    }
}
