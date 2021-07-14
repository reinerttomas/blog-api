<?php
declare(strict_types=1);

namespace App\Tests\Blog\Integration;

use Blog\Core\DateTime;
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

    public function testLoad(): void
    {
        $user = $this->userRepository->get(1);

        $this->assertEquals(1, $user->getId());
        $this->assertEquals('test@test.com', $user->getEmail());
        $this->assertEquals('username', $user->getUsername());
        $this->assertTrue($user->verifyPassword('1234'));
        $this->assertEquals('Test', $user->getName());
        $this->assertEquals('Tester', $user->getSurname());
        $this->assertInstanceOf(DateTime::class, $user->getCreatedAt());
        $this->assertNull($user->getUpdatedAt());
    }
}
