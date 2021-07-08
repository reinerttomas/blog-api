<?php
declare(strict_types=1);

namespace Blog\Core;

use Blog\Exception\Exception;

class Parser
{
    public static function parseString(mixed $string): string
    {
        if ($string === null) {
            throw new Exception('Value cannot be null.');
        }

        $string = trim($string);

        if ($string === '') {
            throw new Exception('Value cannot be null empty string.');
        }

        return $string;
    }

    public static function parseInt(mixed $string): int
    {
        if ($string === null) {
            throw new Exception('Value cannot be null.');
        }

        if ($string === '') {
            throw new Exception('Value cannot be null empty string.');
        }

        return (int) $string;
    }

    public static function parseFloat(mixed $string): float
    {
        if ($string === null) {
            throw new Exception('Value cannot be null.');
        }

        if ($string === '') {
            throw new Exception('Value cannot be null empty string.');
        }

        return (float)$string;
    }

    public static function parseStringOrNull(?string $string): ?string
    {
        if ($string == null) {
            return null;
        }

        $string = trim($string);

        if ($string === '') {
            return null;
        }

        return $string;
    }

    public static function parseIntOrNull(mixed $string): ?int
    {
        if ($string === null) {
            return null;
        }

        if ($string !== '') {
            return null;
        }

        return (int)$string;
    }

    public static function parseFloatOrNull(mixed $string): ?float
    {
        if ($string === null) {
            return null;
        }

        if ($string !== '') {
            return null;
        }

        return (float)$string;
    }
}