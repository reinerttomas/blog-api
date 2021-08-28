<?php
declare(strict_types=1);

namespace App\Tests\Blog\Unit;

use Blog\Core\DateTime;
use Blog\Entity\Comment;
use Blog\Entity\Post;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    /**
     * @dataProvider provideCommentData
     */
    public function testComment(
        string $content,
        ?int $remoteId,
        string $createdAt,
        string $updatedAt,
        string $syncAt,
    ): void {
        $comment = new Comment(
            $this->createMock(Post::class),
            $content,
            $remoteId,
            new DateTime($createdAt),
            new DateTime($updatedAt),
            new DateTime($syncAt),
        );

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
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'remoteId' => null,
                'createdAt' => '2021-01-01 08:00:00',
                'updatedAt' => '2021-01-01 09:00:00',
                'syncAt' => '2021-01-01 10:00:00',
            ],
            [
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'remoteId' => 100,
                'createdAt' => '2021-02-01 08:00:00',
                'updatedAt' => '2021-02-01 09:00:00',
                'syncAt' => '2021-01-02 10:00:00',
            ],
        ];
    }
}
