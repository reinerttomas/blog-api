<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Blog\Core\DateTime;
use Blog\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_LOCAL = 'user.local';
    public const USER_REMOTE = 'user.remote';

    public function load(ObjectManager $manager): void
    {
        $userLocal = new User(
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

        $userRemote = new User(
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

        $manager->persist($userLocal);
        $manager->persist($userRemote);
        $manager->flush();

        $this->addReference(self::USER_LOCAL, $userLocal);
        $this->addReference(self::USER_REMOTE, $userRemote);
    }
}
