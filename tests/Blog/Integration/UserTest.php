<?php
declare(strict_types=1);

namespace App\Tests\Blog\Integration;

use Blog\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $this->userRepository = $container->get(UserRepository::class);
    }

    /**
     * @dataProvider provideUserData
     */
    public function testGetById(
        int $id,
        string $email,
        string $username,
        string $password,
        bool $isVerify,
        string $name,
        string $surname,
        string $createdAt,
        ?string $updatedAt,
    ): void {
        $user = $this->userRepository->get($id);

        self::assertEquals($id, $user->getId());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($username, $user->getUsername());
        self::assertEquals($isVerify, $user->verifyPassword($password));
        self::assertEquals($name, $user->getName());
        self::assertEquals($surname, $user->getSurname());
        self::assertEquals($createdAt, $user->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $user->getUpdatedAt());
    }

    public function provideUserData(): array
    {
        return [
            [
                'id' => 1,
                'email' => 'test@test.com',
                'username' => 'username',
                'password' => '1234',
                'verify' => true,
                'name' => 'Test',
                'surname' => 'Tester',
                'createdAt' => '2021-01-01 08:00:00',
                'updatedAt' => null,
            ],
        ];
    }
}
