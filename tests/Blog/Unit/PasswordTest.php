<?php
declare(strict_types=1);

namespace App\Tests\Blog\Unit;

use Blog\Core\Password;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PasswordTest extends KernelTestCase
{
    /**
     * @dataProvider providePasswordData
     */
    public function testHash(bool $expect, string $password, string $verify): void
    {
        $hash = Password::hash($password);
        $isVerify = Password::verify($verify, $hash);

        self::assertEquals($expect, $isVerify);
    }

    public function providePasswordData(): array
    {
        return [
            [
                'expect' => true,
                'password' => '1234',
                'verify' => '1234',
            ],
            [
                'expect' => false,
                'password' => '1234',
                'verify' => '1111',
            ],
        ];
    }
}
