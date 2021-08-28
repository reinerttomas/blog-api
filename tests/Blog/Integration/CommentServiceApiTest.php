<?php
declare(strict_types=1);

namespace App\Tests\Blog\Integration;

use Blog\Api\JsonPlaceholder\Comment\CommentResponse;
use Blog\Core\DateTime;
use Blog\Services\CommentService;
use ReinertTomas\JsonPlaceholderApi\Comment\CommentResponse as CommentApiResponse;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommentServiceApiTest extends KernelTestCase
{
    private CommentService $commentService;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->commentService = $container->get(CommentService::class);
    }

    /**
     * @dataProvider provideCommentApiData
     */
    public function testApiSync(array $expect, array $input): void
    {
        $syncAt = new DateTime($input['syncAt']);
        $commentApiResponse = new CommentApiResponse($input);
        $commentResponse = new CommentResponse($commentApiResponse);

        $comment = $this->commentService->updateOrCreateFromApi($commentResponse, $syncAt);
        $comment = $this->commentService->get($comment->getId());

        self::assertEquals($expect['postId'], $comment->getPost()->getId());
        self::assertEquals($expect['postRemoteId'], $comment->getPost()->getRemoteId());
        self::assertEquals($expect['content'], $comment->getContent());
        self::assertEquals($expect['remoteId'], $comment->getRemoteId());
        self::assertEquals($expect['createdAt'], $comment->getCreatedAt()->toStringDate());
        self::assertEquals($expect['updatedAt'], $comment->getUpdatedAt()?->toStringDate());
        self::assertEquals($expect['syncAt'], $comment->getSyncAt()->toStringDateTime());
    }

    public function provideCommentApiData(): array
    {
        return [
            [
                [
                    'postId' => 5,
                    'postRemoteId' => 100,
                    'content' => 'alias odio sit',
                    'remoteId' => 1000,
                    'createdAt' => (new DateTime())->toStringDate(),
                    'updatedAt' => null,
                    'syncAt' => '2021-01-01 10:10:10',
                ],
                [
                    'id' => 1000,
                    'postId' => 100,
                    'name' => 'd labore ex et quam laborum',
                    'email' => 'eliseo@gardner.biz',
                    'body' => 'alias odio sit',
                    'syncAt' => '2021-01-01 10:10:10',
                ],
            ],
            [
                [
                    'postId' => 5,
                    'postRemoteId' => 100,
                    'content' => 'lorem ipsum',
                    'remoteId' => 1000,
                    'createdAt' => (new DateTime())->toStringDate(),
                    'updatedAt' => (new DateTime())->toStringDate(),
                    'syncAt' => '2021-01-02 11:11:11',
                ],
                [
                    'id' => 1000,
                    'postId' => 100,
                    'name' => 'd labore ex et quam laborum',
                    'email' => 'eliseo@gardner.biz',
                    'body' => 'lorem ipsum',
                    'syncAt' => '2021-01-02 11:11:11',
                ],
            ],
        ];
    }
}
