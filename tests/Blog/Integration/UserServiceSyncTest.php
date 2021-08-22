<?php
declare(strict_types=1);

namespace App\Tests\Blog\Integration;

use Blog\Api\JsonPlaceholder\User\UserResponse;
use Blog\Core\DateTime;
use Blog\Services\UserService;
use ReinertTomas\JsonPlaceholderApi\User\UserResponse as UserResponseApi;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserServiceSyncTest extends KernelTestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->userService = $container->get(UserService::class);
    }

    /**
     * @dataProvider provideUserApiData
     */
    public function testApiSync(array $expect, array $input): void
    {
        $syncAt = DateTime::fromFormat('Y-m-d H:i:s', $expect['syncAt']);
        $userResponseApi = new UserResponseApi($input);
        $userResponse = new UserResponse($userResponseApi);

        $user = $this->userService->updateOrCreateFromApi($userResponse, $syncAt);
        $user = $this->userService->get($user->getId());

        self::assertEquals($expect['email'], $user->getEmail());
        self::assertEquals($expect['username'], $user->getUsername());
        self::assertEquals($expect['password'], $user->getPassword());
        self::assertEquals($expect['name'], $user->getName());
        self::assertEquals($expect['surname'], $user->getSurname());
        self::assertEquals($expect['remoteId'], $user->getRemoteId());
        self::assertEquals($expect['createdAt'], $user->getCreatedAt()?->toStringDate());
        self::assertEquals($expect['updatedAt'], $user->getUpdatedAt()?->toStringDate());
        self::assertEquals($expect['syncAt'], $user->getSyncAt()->toStringDateTime());
    }

    public function provideUserApiData(): array
    {
        return [
            [
                [
                    'email' => 'Sincere@april.biz',
                    'username' => 'Bret',
                    'password' => null,
                    'name' => 'Leanne',
                    'surname' => 'Graham',
                    'remoteId' => 1000,
                    'createdAt' => (new DateTime())->toStringDate(),
                    'updatedAt' => null,
                    'syncAt' => '2021-01-01 08:00:00',
                ],
                [
                    'id' => 1000,
                    'name' => 'Leanne Graham',
                    'username' => 'Bret',
                    'email' => 'Sincere@april.biz',
                    'address' => [
                        'street' => 'Kulas Light',
                        'suite' => 'Apt. 556',
                        'city' => 'Gwenborough',
                        'zipcode' => '92998-3874',
                        'geo' => [
                            'lat' => -37.3159,
                            'lng' => 81.1496,
                        ],
                    ],
                    'phone' => '1-770-736-8031 x56442',
                    'website' => 'hildegard.org',
                    'company' => [
                        'name' => 'Romaguera-Crona',
                        'catchPhrase' => 'Multi-layered client-server neural-net',
                        'bs' => 'harness real-time e-markets',
                    ],
                ],
            ],
            [
                [
                    'email' => 'SincereX@april.biz',
                    'username' => 'BretX',
                    'password' => null,
                    'name' => 'LeanneX',
                    'surname' => 'GrahamX',
                    'remoteId' => 1000,
                    'createdAt' => (new DateTime())->toStringDate(),
                    'updatedAt' => (new DateTime())->toStringDate(),
                    'syncAt' => '2021-01-01 08:00:00',
                ],
                [
                    'id' => 1000,
                    'name' => 'LeanneX GrahamX',
                    'username' => 'BretX',
                    'email' => 'SincereX@april.biz',
                    'address' => [
                        'street' => 'Kulas Light',
                        'suite' => 'Apt. 556',
                        'city' => 'Gwenborough',
                        'zipcode' => '92998-3874',
                        'geo' => [
                            'lat' => -37.3159,
                            'lng' => 81.1496,
                        ],
                    ],
                    'phone' => '1-770-736-8031 x56442',
                    'website' => 'hildegard.org',
                    'company' => [
                        'name' => 'Romaguera-Crona',
                        'catchPhrase' => 'Multi-layered client-server neural-net',
                        'bs' => 'harness real-time e-markets',
                    ],
                ],
            ],
        ];
    }
}
