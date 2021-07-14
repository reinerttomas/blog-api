<?php
declare(strict_types=1);

namespace App\Tests\Blog\Unit;

use Blog\Core\DateTime;
use Blog\Entity\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testPost(): void
    {
        $post = new Post(
            'Lorem Ipsum is simply',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        );

        $this->assertEquals('Lorem Ipsum is simply', $post->getTitle());
        $this->assertEquals('lorem-ipsum-is-simply', $post->getSlug());
        $this->assertEquals(
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            $post->getContent(),
        );
        $this->assertInstanceOf(DateTime::class, $post->getCreatedAt());
        $this->assertNull($post->getUpdatedAt());
    }
}
