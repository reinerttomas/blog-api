<?php
declare(strict_types=1);

namespace Blog\Factory\Api;

use Blog\Dto\Api\PostRequestDto;
use Blog\Repository\UserRepository;

class PostRequestFactory
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $data): PostRequestDto
    {
        $user = $this->userRepository->get($data['userId']);

        return new PostRequestDto(
            $user,
            $data['title'],
            $data['content'],
        );
    }
}
