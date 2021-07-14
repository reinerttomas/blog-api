<?php
declare(strict_types=1);

namespace App\Tests\Blog\Unit;

use Blog\Core\DateTime;
use Blog\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUser(): void
    {
        $user = new User(
            'test@test.com',
            'username',
            '1234',
            'test',
            'tester',
        );

        $this->assertEquals('test@test.com', $user->getEmail());
        $this->assertEquals('username', $user->getUsername());
        $this->assertTrue($user->verifyPassword('1234'));
        $this->assertFalse($user->verifyPassword('1111'));
        $this->assertEquals('Test', $user->getName());
        $this->assertEquals('Tester', $user->getSurname());
        $this->assertInstanceOf(DateTime::class, $user->getCreatedAt());
        $this->assertNull($user->getUpdatedAt());
    }
}