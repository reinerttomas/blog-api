<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Blog\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $post1 = new Post(
            'qui est esse',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        );

        $post2 = new Post(
            'ea molestias quasi',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        );

        $post3 = new Post(
            'eum et est occaecati',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        );

        $post4 = new Post(
            'nesciunt quas odio',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        );

        $post5 = new Post(
            'dolorem eum magni eos aperiam quia',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        );

        $manager->persist($post1);
        $manager->persist($post2);
        $manager->persist($post3);
        $manager->persist($post4);
        $manager->persist($post5);
        $manager->flush();
    }
}
