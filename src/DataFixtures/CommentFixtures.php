<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Blog\Core\DateTime;
use Blog\Entity\Comment;
use Blog\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Post $post1 */
        $post1 = $this->getReference(PostFixtures::POST_1);

        /** @var Post $post5 */
        $post5 = $this->getReference(PostFixtures::POST_5);

        $comment1 = $this->getComment(
            $post1,
            'Audantium enim quasi est quidem magnam voluptate.',
            null,
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-01 08:00:00'),
            null,
            null,
        );

        $comment2 = $this->getComment(
            $post5,
            'Est natus enim nihil est dolore omnis voluptatem.',
            100,
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-02 08:00:00'),
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-02 09:00:00'),
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-02 10:00:00'),
        );

        $comment3 = $this->getComment(
            $post5,
            'Doloribus at sed quis culpa deserunt consectetur.',
            101,
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-02-03 08:00:00'),
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-02-03 09:00:00'),
            DateTime::fromFormat(' Y-m-d h:i:s', '2021-01-03 10:00:00'),
        );


        $manager->persist($comment1);
        $manager->persist($comment2);
        $manager->persist($comment3);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PostFixtures::class,
        ];
    }

    #[Pure]
    private function getComment(
        Post $post,
        string $content,
        ?int $remoteId,
        DateTime $createdAt,
        ?DateTime $updatedAt,
        ?DateTime $syncAt,
    ): Comment {
        return new Comment(
            $post,
            $content,
            $remoteId,
            $createdAt,
            $updatedAt,
            $syncAt,
        );
    }
}
