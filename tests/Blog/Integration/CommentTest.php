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
        string $content,
        string $createdAt,
        ?string $updatedAt,
    ): void {
        $comment = $this->commentRepository->get($id);

        self::assertEquals($id, $comment->getId());
        self::assertEquals($content, $comment->getContent());
        self::assertEquals($createdAt, $comment->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $comment->getUpdatedAt());
    }

    public function provideCommentData(): array
    {
        return [
            [
                'id' => 1,
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'createdAt' => '2021-01-01 08:00:00',
                'updatedAt' => null,
            ],
        ];
    }
}
