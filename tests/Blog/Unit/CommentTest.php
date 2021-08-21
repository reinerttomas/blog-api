<?php
declare(strict_types=1);

namespace App\Tests\Blog\Unit;

use Blog\Core\DateTime;
use Blog\Entity\Comment;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    /**
     * @dataProvider provideCommentData
     */
    public function testComment(
        string $content,
        string $createdAt,
        string $updatedAt,
    ): void {
        $comment = new Comment(
            $content,
            new DateTime($createdAt),
            new DateTime($updatedAt),
        );

        self::assertEquals($content, $comment->getContent());
        self::assertEquals($createdAt, $comment->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $comment->getUpdatedAt()->toStringDateTime());
    }

    public function provideCommentData(): array
    {
        return [
            [
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'createdAt' => '2021-01-01 08:00:00',
                'updatedAt' => '2021-01-01 09:00:00',
            ],
        ];
    }
}
