<?php
declare(strict_types=1);

namespace App\Tests\Blog\Unit;

use Blog\Core\Password;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PasswordTest extends KernelTestCase
{
    public function testPasswordVerifyTrue(): void
    {
        $hash = Password::hash('1234');
        $isVerify = Password::verify('1234', $hash);

        $this->assertTrue($isVerify);
    }

    public function testPasswordVerifyFalse(): void
    {
        $hash = Password::hash('1234');
        $isVerify = Password::verify('1111', $hash);

        $this->assertFalse($isVerify);
    }
}
