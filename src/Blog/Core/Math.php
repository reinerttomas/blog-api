<?php
declare(strict_types=1);

namespace Blog\Core;

class Math
{
    public static function round(
        int|float $num,
        int $precision = 0,
        int $mode = PHP_ROUND_HALF_UP,
    ): float {
        return round($num, $precision, $mode);
    }

    public static function intval(mixed $value, int $base = 10): int
    {
        return intval($value, $base);
    }
}
