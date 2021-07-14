<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Blog\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $comment1 = new Comment('Lorem Ipsum is simply dummy text of the printing and typesetting industry.');

        $manager->persist($comment1);
        $manager->flush();
    }
}
