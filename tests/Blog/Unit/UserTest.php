<?php
declare(strict_types=1);

namespace App\Tests\Blog\Unit;

use Blog\Core\DateTime;
use Blog\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @dataProvider provideUserData
     */
    public function testUser(array $expected, array $input): void
    {
        $user = new User(
            $input['email'],
            $input['username'],
            $input['password'],
            $input['name'],
            $input['surname'],
            $input['remoteId'],
            new DateTime($input['createdAt']),
            new DateTime($input['updatedAt']),
            new DateTime($input['syncAt']),
        );

        self::assertEquals($expected['email'], $user->getEmail());
        self::assertEquals($expected['username'], $user->getUsername());
        self::assertEquals($expected['password'], $user->verifyPassword($input['password']));
        self::assertEquals($expected['name'], $user->getName());
        self::assertEquals($expected['surname'], $user->getSurname());
        self::assertEquals($expected['remoteId'], $user->getRemoteId());
        self::assertEquals($expected['createdAt'], $user->getCreatedAt());
        self::assertEquals($expected['updatedAt'], $user->getUpdatedAt());
        self::assertEquals($expected['syncAt'], $user->getSyncAt());
    }

    public function provideUserData(): array
    {
        return [
            [
                [
                    'email' => 'test@test.com',
                    'username' => 'username',
                    'password' => true,
                    'name' => 'Test',
                    'surname' => 'Tester',
                    'remoteId' => 100,
                    'createdAt' => '2021-01-01 08:00:00',
                    'updatedAt' => '2021-01-01 09:00:00',
                    'syncAt' => '2021-01-01 10:00:00',
                ],
                [
                    'email' => 'test@test.com',
                    'username' => 'username',
                    'password' => '1234',
                    'name' => 'test',
                    'surname' => 'tester',
                    'remoteId' => 100,
                    'createdAt' => '2021-01-01 08:00:00',
                    'updatedAt' => '2021-01-01 09:00:00',
                    'syncAt' => '2021-01-01 10:00:00',
                ],
            ],
        ];
    }
}
