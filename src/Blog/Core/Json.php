<?php
declare(strict_types=1);

namespace Blog\Core;

use Blog\Exception\JsonException;

class Json
{
    public static function encode(?array $array): string
    {
        if ($array === null) {
            throw new JsonException('Array is null');
        }

        try {
            return json_encode($array, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new JsonException($e->getMessage());
        }
    }

    public static function decode(?string $string): array
    {
        if ($string === null) {
            throw new JsonException('String is null');
        }

        try {
            return json_decode($string, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new JsonException($e->getMessage());
        }
    }

    public static function validate(?string $string): bool
    {
        if ($string === null) {
            return false;
        }

        try {
            json_decode($string, true, 512, JSON_THROW_ON_ERROR);

            return true;
        } catch (\JsonException $e) {
            return false;
        }
    }
}
