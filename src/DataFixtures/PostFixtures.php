<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Blog\Core\DateTime;
use Blog\Entity\Post;
use Blog\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public const POST_1 = 'post.1';
    public const POST_5 = 'post.5';

    public function load(ObjectManager $manager): void
    {
        /** @var User $userLocal */
        $userLocal = $this->getReference(UserFixtures::USER_1);

        /** @var User $userRemote */
        $userRemote = $this->getReference(UserFixtures::USER_2);

        $post1 = $this->getPost(
            $userLocal,
            'qui est esse',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            null,
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 08:01:00'),
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 09:01:00'),
            null,
        );

        $post2 = $this->getPost(
            $userLocal,
            'ea molestias quasi',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            null,
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 08:02:00'),
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 09:02:00'),
            null,
        );

        $post3 = $this->getPost(
            $userLocal,
            'eum et est occaecati',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            null,
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 08:03:00'),
            null,
            null,
        );

        $post4 = $this->getPost(
            $userRemote,
            'nesciunt quas odio',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            null,
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 08:04:00'),
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 09:04:00'),
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 12:04:00'),
        );

        $post5 = $this->getPost(
            $userRemote,
            'dolorem eum magni eos aperiam quia',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            100,
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 08:05:00'),
            null,
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 12:05:00'),
        );

        $manager->persist($post1);
        $manager->persist($post2);
        $manager->persist($post3);
        $manager->persist($post4);
        $manager->persist($post5);
        $manager->flush();

        $this->addReference(self::POST_1, $post1);
        $this->addReference(self::POST_5, $post5);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    private function getPost(
        User $user,
        string $title,
        string $content,
        ?int $remoteId,
        DateTime $createdAt,
        ?DateTime $updatedAt,
        ?DateTime $syncAt,
    ): Post {
        return new Post(
            $user,
            $title,
            $content,
            $remoteId,
            $createdAt,
            $updatedAt,
            $syncAt,
        );
    }
}
