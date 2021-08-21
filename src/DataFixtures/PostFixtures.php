<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Blog\Core\DateTime;
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
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 08:00:00'),
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-02 09:00:00'),
        );

        $post2 = new Post(
            'ea molestias quasi',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-02 09:00:00'),
            null,
        );

        $post3 = new Post(
            'eum et est occaecati',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-03 10:00:00'),
            null,
        );

        $post4 = new Post(
            'nesciunt quas odio',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-04 11:00:00'),
            null,
        );

        $post5 = new Post(
            'dolorem eum magni eos aperiam quia',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-05 12:00:00'),
            null,
        );

        $manager->persist($post1);
        $manager->persist($post2);
        $manager->persist($post3);
        $manager->persist($post4);
        $manager->persist($post5);
        $manager->flush();
    }
}
