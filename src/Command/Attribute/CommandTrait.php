<?php
declare(strict_types=1);

namespace App\Command\Attribute;

use Symfony\Component\Console\Command\Command;

/**
 * @mixin Command
 */
trait CommandTrait
{
    private function defaultName(): string
    {
        return (string)self::$defaultName;
    }

    private function defaultDescription(): string
    {
        return (string)self::$defaultDescription;
    }
}
