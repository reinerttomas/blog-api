<?php
declare(strict_types=1);

namespace App\Tests\Blog\Functional;

use Blog\Core\Json;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogTest extends WebTestCase
{
    public function testResponseCode(): void
    {
        $client = static::createClient();

        $client->request('GET', '/posts');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPosts(): void
    {
        $client = static::createClient();
        $client->request('GET', '/posts');

        $content = $client->getResponse()->getContent();
        $result = Json::decode($content);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('page', $result);
        $this->assertArrayHasKey('limit', $result);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals(1, $result['page']);
        $this->assertEquals(10, $result['limit']);
    }
}
