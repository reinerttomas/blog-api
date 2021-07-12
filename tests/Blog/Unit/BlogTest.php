<?php
declare(strict_types=1);

namespace App\Tests\Blog\Unit;

use Blog\Core\DateTime;
use Blog\Entity\Post;
use PHPUnit\Framework\TestCase;

class BlogTest extends TestCase
{
    public function testPost(): void
    {
        $createdAt = new DateTime();

        $blog = new Post(
            'Lorem Ipsum is simply',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        );

        $this->assertEquals('Lorem Ipsum is simply', $blog->getTitle());
        $this->assertEquals('lorem-ipsum-is-simply', $blog->getSlug());
        $this->assertEquals(
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            $blog->getContent(),
        );
        $this->assertEquals($createdAt->format('Y-m-d'), $blog->getCreatedAt()->format('Y-m-d'));
    }
}
