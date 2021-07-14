<?php
declare(strict_types=1);

namespace App\Tests\Blog\Integration;

use Blog\Core\DateTime;
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

    public function testLoad(): void
    {
        $comment = $this->commentRepository->get(1);

        $this->assertEquals(1, $comment->getId());
        $this->assertEquals(
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            $comment->getContent(),
        );
        $this->assertInstanceOf(DateTime::class, $comment->getCreatedAt());
        $this->assertNull($comment->getUpdatedAt());
    }
}
