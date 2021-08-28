<?php
declare(strict_types=1);

namespace App\Tests\Blog\Integration;

use Blog\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommentTest extends KernelTestCase
{
    private CommentRepository $commentRepository;

    protected function setUp(): void
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $this->commentRepository = $container->get(CommentRepository::class);
    }

    /**
     * @dataProvider provideCommentData
     */
    public function testGetById(
        int $id,
        int $postId,
        string $content,
        ?int $remoteId,
        string $createdAt,
        ?string $updatedAt,
        ?string $syncAt,
    ): void {
        $comment = $this->commentRepository->get($id);

        self::assertEquals($id, $comment->getId());
        self::assertEquals($postId, $comment->getPost()->getId());
        self::assertEquals($content, $comment->getContent());
        self::assertEquals($remoteId, $comment->getRemoteId());
        self::assertEquals($createdAt, $comment->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $comment->getUpdatedAt()?->toStringDateTime());
        self::assertEquals($syncAt, $comment->getSyncAt()?->toStringDateTime());
    }

    /**
     * @dataProvider provideCommentApiData
     */
    public function testGetByRemoteId(
        int $id,
        int $postId,
        string $content,
        int $remoteId,
        string $createdAt,
        string $updatedAt,
        string $syncAt,
    ): void {
        $comment = $this->commentRepository->getByRemoteId($remoteId);

        self::assertEquals($id, $comment->getId());
        self::assertEquals($postId, $comment->getPost()->getId());
        self::assertEquals($content, $comment->getContent());
        self::assertEquals($remoteId, $comment->getRemoteId());
        self::assertEquals($createdAt, $comment->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $comment->getUpdatedAt()->toStringDateTime());
        self::assertEquals($syncAt, $comment->getSyncAt()->toStringDateTime());
    }

    public function provideCommentData(): array
    {
        return [
            [
                'id' => 1,
                'postId' => 1,
                'content' => 'Audantium enim quasi est quidem magnam voluptate.',
                'remoteId' => null,
                'createdAt' => '2021-01-01 08:00:00',
                'updatedAt' => null,
                'syncAt' => null,
            ],
            [
                'id' => 2,
                'postId' => 5,
                'content' => 'Est natus enim nihil est dolore omnis voluptatem.',
                'remoteId' => 100,
                'createdAt' => '2021-01-02 08:00:00',
                'updatedAt' => '2021-01-02 09:00:00',
                'syncAt' => '2021-01-02 10:00:00',
            ],
        ];
    }

    public function provideCommentApiData(): array
    {
        return [
            [
                'id' => 2,
                'postId' => 5,
                'content' => 'Est natus enim nihil est dolore omnis voluptatem.',
                'remoteId' => 100,
                'createdAt' => '2021-01-02 08:00:00',
                'updatedAt' => '2021-01-02 09:00:00',
                'syncAt' => '2021-01-02 10:00:00',
            ],
        ];
    }
}
