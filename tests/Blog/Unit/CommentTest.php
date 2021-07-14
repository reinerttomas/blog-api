<?php
declare(strict_types=1);

namespace App\Tests\Blog\Unit;

use Blog\Core\DateTime;
use Blog\Entity\Comment;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testComment(): void
    {
        $comment = new Comment('Lorem Ipsum is simply dummy text of the printing and typesetting industry.');

        $this->assertEquals(
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            $comment->getContent(),
        );
        $this->assertInstanceOf(DateTime::class, $comment->getCreatedAt());
        $this->assertNull($comment->getUpdatedAt());
    }
}
