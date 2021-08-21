<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Blog\Core\DateTime;
use Blog\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $comment1 = new Comment(
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 08:00:00'),
            null,
        );

        $manager->persist($comment1);
        $manager->flush();
    }
}
