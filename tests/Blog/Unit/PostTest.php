<?php
declare(strict_types=1);

namespace App\Tests\Blog\Unit;

use Blog\Core\DateTime;
use Blog\Entity\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    /**
     * @dataProvider providePostData
     */
    public function testPost(array $expect, array $input): void
    {
        $post = new Post(
            $input['title'],
            $input['content'],
            new DateTime($input['createdAt']),
            new DateTime($input['updatedAt']),
        );

        self::assertEquals($expect['title'], $post->getTitle());
        self::assertEquals($expect['slug'], $post->getSlug());
        self::assertEquals($expect['content'], $post->getContent());
        self::assertEquals($expect['createdAt'], $post->getCreatedAt()->toStringDateTime());
        self::assertEquals($expect['updatedAt'], $post->getUpdatedAt()->toStringDateTime());
    }

    public function providePostData(): array
    {
        return [
            [
                [
                    'title' => 'Lorem Ipsum is simply',
                    'slug' => 'lorem-ipsum-is-simply',
                    'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                    'createdAt' => '2021-01-01 08:00:00',
                    'updatedAt' => '2021-01-01 09:00:00',
                ],
                [
                    'title' => 'Lorem Ipsum is simply',
                    'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                    'createdAt' => '2021-01-01 08:00:00',
                    'updatedAt' => '2021-01-01 09:00:00',
                ],
            ],
        ];
    }
}
