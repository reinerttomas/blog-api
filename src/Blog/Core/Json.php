<?php
declare(strict_types=1);

namespace Blog\Core;

use Blog\Exception\JsonException;

class Json
{
    public static function encode(array $array): string
    {
        try {
            return json_encode($array, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new JsonException($e->getMessage());
        }
    }

    public static function decode(string $json): array
    {
        try {
            return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new JsonException($e->getMessage());
        }
    }

    public static function validate(string $json): bool
    {
        $array = json_decode($json, true);

        if ($array === null) {
            return false;
        }

        return true;
    }
}
