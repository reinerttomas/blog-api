<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;

/**
 * @mixin Command
 */
trait DescriptionTrait
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
