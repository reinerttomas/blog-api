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
        ?int $remoteId,
        string $createdAt,
        ?string $updatedAt,
        ?string $syncAt,
    ): void {
        $user = $this->userRepository->get($id);

        self::assertEquals($id, $user->getId());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($username, $user->getUsername());
        self::assertEquals($isVerify, $user->verifyPassword($password));
        self::assertEquals($name, $user->getName());
        self::assertEquals($surname, $user->getSurname());
        self::assertEquals($remoteId, $user->getRemoteId());
        self::assertEquals($createdAt, $user->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $user->getUpdatedAt()?->toStringDateTime());
        self::assertEquals($syncAt, $user->getSyncAt()?->toStringDateTime());
    }

    /**
     * @dataProvider provideUserData
     */
    public function testByEmail(
        int $id,
        string $email,
        string $username,
        string $password,
        bool $isVerify,
        string $name,
        string $surname,
        ?int $remoteId,
        string $createdAt,
        ?string $updatedAt,
        ?string $syncAt,
    ): void {
        $user = $this->userRepository->getByEmail($email);

        self::assertEquals($id, $user->getId());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($username, $user->getUsername());
        self::assertEquals($isVerify, $user->verifyPassword($password));
        self::assertEquals($name, $user->getName());
        self::assertEquals($surname, $user->getSurname());
        self::assertEquals($remoteId, $user->getRemoteId());
        self::assertEquals($createdAt, $user->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $user->getUpdatedAt()?->toStringDateTime());
        self::assertEquals($syncAt, $user->getSyncAt()?->toStringDateTime());
    }

    /**
     * @dataProvider provideUserData
     */
    public function testByUsername(
        int $id,
        string $email,
        string $username,
        string $password,
        bool $isVerify,
        string $name,
        string $surname,
        ?int $remoteId,
        string $createdAt,
        ?string $updatedAt,
        ?string $syncAt,
    ): void {
        $user = $this->userRepository->getByUsername($username);

        self::assertEquals($id, $user->getId());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($username, $user->getUsername());
        self::assertEquals($isVerify, $user->verifyPassword($password));
        self::assertEquals($name, $user->getName());
        self::assertEquals($surname, $user->getSurname());
        self::assertEquals($remoteId, $user->getRemoteId());
        self::assertEquals($createdAt, $user->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $user->getUpdatedAt()?->toStringDateTime());
        self::assertEquals($syncAt, $user->getSyncAt()?->toStringDateTime());
    }

    /**
     * @dataProvider provideUserApiData
     */
    public function testByRemoteId(
        int $id,
        string $email,
        string $username,
        string $password,
        bool $isVerify,
        string $name,
        string $surname,
        int $remoteId,
        string $createdAt,
        ?string $updatedAt,
        ?string $syncAt,
    ): void {
        $user = $this->userRepository->getByRemoteId($remoteId);

        self::assertEquals($id, $user->getId());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($username, $user->getUsername());
        self::assertEquals($isVerify, $user->verifyPassword($password));
        self::assertEquals($name, $user->getName());
        self::assertEquals($surname, $user->getSurname());
        self::assertEquals($remoteId, $user->getRemoteId());
        self::assertEquals($createdAt, $user->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $user->getUpdatedAt()?->toStringDateTime());
        self::assertEquals($syncAt, $user->getSyncAt()?->toStringDateTime());
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
                'remoteId' => null,
                'createdAt' => '2021-01-01 08:00:00',
                'updatedAt' => null,
                'syncAt' => null,
            ],
            [
                'id' => 2,
                'email' => 'remote@api.com',
                'username' => 'remoteapi',
                'password' => '1234',
                'verify' => false,
                'name' => 'Remote',
                'surname' => 'Api',
                'remoteId' => 100,
                'createdAt' => '2021-01-01 08:00:00',
                'updatedAt' => '2021-01-02 09:00:00',
                'syncAt' => '2021-01-03 10:00:00',
            ],
        ];
    }

    public function provideUserApiData(): array
    {
        return [
            [
                'id' => 2,
                'email' => 'remote@api.com',
                'username' => 'remoteapi',
                'password' => '4321',
                'verify' => true,
                'name' => 'Remote',
                'surname' => 'Api',
                'remoteId' => 100,
                'createdAt' => '2021-01-01 08:00:00',
                'updatedAt' => '2021-01-02 09:00:00',
                'syncAt' => '2021-01-03 10:00:00',
            ],
        ];
    }
}
