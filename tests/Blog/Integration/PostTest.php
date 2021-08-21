<?php
declare(strict_types=1);

namespace App\Tests\Blog\Integration;

use Blog\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostTest extends KernelTestCase
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

    /**
     * @dataProvider providePostData
     */
    public function testGetById(
        int $id,
        string $slug,
        string $title,
        string $content,
        string $createdAt,
        ?string $updatedAt,
    ): void {
        $post = $this->postRepository->get($id);

        self::assertEquals($id, $post->getId());
        self::assertEquals($slug, $post->getSlug());
        self::assertEquals($title, $post->getTitle());
        self::assertEquals($content, $post->getContent());
        self::assertEquals($createdAt, $post->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $post->getUpdatedAt());
    }

    /**
     * @dataProvider providePostData
     */
    public function testGetBySlug(
        int $id,
        string $slug,
        string $title,
        string $content,
        string $createdAt,
        ?string $updatedAt,
    ): void {
        $post = $this->postRepository->getBySlug($slug);

        self::assertEquals($id, $post->getId());
        self::assertEquals($slug, $post->getSlug());
        self::assertEquals($title, $post->getTitle());
        self::assertEquals($content, $post->getContent());
        self::assertEquals($createdAt, $post->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $post->getUpdatedAt());
    }

    public function providePostData(): array
    {
        return [
            [
                'id' => 1,
                'slug' => 'qui-est-esse',
                'title' => 'qui est esse',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'createdAt' => '2021-01-01 08:00:00',
                'updatedAt' => '2021-01-02 09:00:00',
            ],
        ];
    }
}
