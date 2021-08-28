<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Blog\Core\DateTime;
use Blog\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_1 = 'user.1';
    public const USER_2 = 'user.2';

    public function load(ObjectManager $manager): void
    {
        $user1 = $this->getUser(
            'test@test.com',
            'username',
            '1234',
            'test',
            'tester',
            null,
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 08:00:00'),
            null,
            null,
        );

        $user2 = $this->getUser(
            'remote@api.com',
            'remoteapi',
            '4321',
            'remote',
            'api',
            100,
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 08:00:00'),
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-02 09:00:00'),
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-03 10:00:00'),
        );

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();

        $this->addReference(self::USER_1, $user1);
        $this->addReference(self::USER_2, $user2);
    }

    private function getUser(
        string $email,
        string $username,
        string $password,
        string $name,
        string $surname,
        ?int $remoteId,
        DateTime $createdAt,
        ?DateTime $updatedAt,
        ?DateTime $syncAt,
    ): User {
        return new User(
            $email,
            $username,
            $password,
            $name,
            $surname,
            $remoteId,
            $createdAt,
            $updatedAt,
            $syncAt,
        );
    }
}
