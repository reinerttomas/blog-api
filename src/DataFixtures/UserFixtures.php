<?php
declare(strict_types=1);

namespace App\DataFixtures;

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
        );

        $manager->persist($user1);
        $manager->flush();
    }
}
