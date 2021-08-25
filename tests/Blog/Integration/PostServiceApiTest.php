<?php
declare(strict_types=1);

namespace App\Tests\Blog\Integration;

use Blog\Api\JsonPlaceholder\Post\PostResponse;
use Blog\Core\DateTime;
use Blog\Services\PostService;
use ReinertTomas\JsonPlaceholderApi\Post\PostResponse as PostApiResponse;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostServiceApiTest extends KernelTestCase
{
    private PostService $postService;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->postService = $container->get(PostService::class);
    }

    /**
     * @dataProvider providePostApiData
     */
    public function testApiSync(array $expect, array $input): void
    {
        $syncAt = new DateTime($input['syncAt']);
        $postApiResponse = new PostApiResponse($input);
        $postResponse = new PostResponse($postApiResponse);

        $post = $this->postService->updateOrCreateFromApi($postResponse, $syncAt);
        $post = $this->postService->get($post->getId());

        self::assertEquals($expect['authorId'], $post->getAuthor()->getId());
        self::assertEquals($expect['authorRemoteId'], $post->getAuthor()->getRemoteId());
        self::assertEquals($expect['slug'], $post->getSlug());
        self::assertEquals($expect['title'], $post->getTitle());
        self::assertEquals($expect['content'], $post->getContent());
        self::assertEquals($expect['remoteId'], $post->getRemoteId());
        self::assertEquals($expect['createdAt'], $post->getCreatedAt()->toStringDate());
        self::assertEquals($expect['updatedAt'], $post->getUpdatedAt()?->toStringDate());
        self::assertEquals($expect['syncAt'], $post->getSyncAt()->toStringDateTime());
    }

    public function providePostApiData(): array
    {
        return [
            [
                [
                    'authorId' => 2,
                    'authorRemoteId' => 100,
                    'slug' => 'quia-et-suscipit',
                    'title' => 'quia et suscipit',
                    'content' => 'accusamus beatae',
                    'remoteId' => 1000,
                    'createdAt' => (new DateTime())->toStringDate(),
                    'updatedAt' => null,
                    'syncAt' => '2021-01-01 10:10:10',
                ],
                [
                    'id' => 1000,
                    'userId' => 100,
                    'title' => 'quia et suscipit',
                    'body' => 'accusamus beatae',
                    'syncAt' => '2021-01-01 10:10:10',
                ],
            ],
            [
                [
                    'authorId' => 2,
                    'authorRemoteId' => 100,
                    'slug' => 'accusamus-beatae',
                    'title' => 'accusamus beatae',
                    'content' => 'quia et suscipit',
                    'remoteId' => 1000,
                    'createdAt' => (new DateTime())->toStringDate(),
                    'updatedAt' => (new DateTime())->toStringDate(),
                    'syncAt' => '2021-01-02 11:11:11',
                ],
                [
                    'id' => 1000,
                    'userId' => 100,
                    'title' => 'accusamus beatae',
                    'body' => 'quia et suscipit',
                    'syncAt' => '2021-01-02 11:11:11',
                ],
            ],
        ];
    }
}
