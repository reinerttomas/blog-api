<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Blog\Core\DateTime;
use Blog\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user1 = new User(
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

        $user2 = new User(
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
    }
}
