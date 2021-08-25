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
        int $authorId,
        string $slug,
        string $title,
        string $content,
        ?int $remoteId,
        string $createdAt,
        ?string $updatedAt,
        ?string $syncAt,
    ): void {
        $post = $this->postRepository->get($id);

        self::assertEquals($id, $post->getId());
        self::assertEquals($authorId, $post->getAuthor()->getId());
        self::assertEquals($slug, $post->getSlug());
        self::assertEquals($title, $post->getTitle());
        self::assertEquals($content, $post->getContent());
        self::assertEquals($remoteId, $post->getRemoteId());
        self::assertEquals($createdAt, $post->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $post->getUpdatedAt()?->toStringDateTime());
        self::assertEquals($syncAt, $post->getSyncAt()?->toStringDateTime());
    }

    /**
     * @dataProvider providePostData
     */
    public function testGetBySlug(
        int $id,
        int $authorId,
        string $slug,
        string $title,
        string $content,
        ?int $remoteId,
        string $createdAt,
        ?string $updatedAt,
        ?string $syncAt,
    ): void {
        $post = $this->postRepository->getBySlug($slug);

        self::assertEquals($id, $post->getId());
        self::assertEquals($authorId, $post->getAuthor()->getId());
        self::assertEquals($slug, $post->getSlug());
        self::assertEquals($title, $post->getTitle());
        self::assertEquals($content, $post->getContent());
        self::assertEquals($remoteId, $post->getRemoteId());
        self::assertEquals($createdAt, $post->getCreatedAt()->toStringDateTime());
        self::assertEquals($updatedAt, $post->getUpdatedAt()?->toStringDateTime());
        self::assertEquals($syncAt, $post->getSyncAt()?->toStringDateTime());
    }

    public function providePostData(): array
    {
        return [
            [
                'id' => 1,
                'authorId' => 1,
                'slug' => 'qui-est-esse',
                'title' => 'qui est esse',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'remoteId' => null,
                'createdAt' => '2021-01-01 08:01:00',
                'updatedAt' => '2021-01-01 09:01:00',
                'syncAt' => null,
            ],
            [
                'id' => 5,
                'authorId' => 2,
                'slug' => 'dolorem-eum-magni-eos-aperiam-quia',
                'title' => 'dolorem eum magni eos aperiam quia',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'remoteId' => 100,
                'createdAt' => '2021-01-01 08:05:00',
                'updatedAt' => null,
                'syncAt' => '2021-01-01 12:05:00',
            ],
        ];
    }
}
