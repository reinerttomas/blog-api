<?php
declare(strict_types=1);

namespace App\Tests\Blog\Integration;

use Blog\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BlogTest extends KernelTestCase
{
    private PostRepository $postRepository;

    protected function setUp(): void
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $this->postRepository = $container->get(PostRepository::class);
    }

    public function testEquals(): void
    {
        $post = $this->postRepository->get(1);

        $this->assertEquals(1, $post->getId());
    }
}
