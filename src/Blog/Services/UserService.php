<?php
declare(strict_types=1);

namespace Blog\Services;

use Blog\Api\JsonPlaceholder\User\UserResponse;
use Blog\Business\UserBusiness;
use Blog\Core\DateTime;
use Blog\Entity\User;

class UserService
{
    private UserBusiness $userBusiness;

    public function __construct(UserBusiness $userBusiness)
    {
        $this->userBusiness = $userBusiness;
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
