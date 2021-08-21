<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\User;

use ReinertTomas\JsonPlaceholderApi\User\User as UserApi;

class User
{
    private UserApi $userApi;

    public function __construct(UserApi $userApi)
    {
        $this->userApi = $userApi;
    }

    public function get(int $id): UserResponse
    {
        $response = $this->userApi->get($id);

        return new UserResponse($response);
    }

    /**
     * @return array<int, UserResponse>
     */
    public function list(): array
    {
        $users = [];

        $responses = $this->userApi->list();

        foreach ($responses as $response) {
            $users[] = new UserResponse($response);
        }

        return $users;
    }
}
