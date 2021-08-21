<?php
declare(strict_types=1);

namespace App\Tests\Blog\Functional;

use Blog\Core\Json;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostTest extends WebTestCase
{
    public function testResponseCode(): void
    {
        $client = static::createClient();

        $client->request('GET', '/posts');

        self::assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider providePostsData
     */
    public function testPosts(int $page, int $limit, int $count): void
    {
        $client = static::createClient();
        $client->request('GET', '/posts');

        $content = $client->getResponse()->getContent();
        $result = Json::decode($content);

        self::assertIsArray($result);
        self::assertArrayHasKey('page', $result);
        self::assertArrayHasKey('limit', $result);
        self::assertArrayHasKey('data', $result);
        self::assertEquals($page, $result['page']);
        self::assertEquals($limit, $result['limit']);
        self::assertEquals($count, count($result['data']));
    }

    public function providePostsData(): array
    {
        return [
            [
                'page' => 1,
                'limit' => 10,
                'count' => 5,
            ],
        ];
    }
}
