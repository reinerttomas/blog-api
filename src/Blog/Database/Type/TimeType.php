<?php
declare(strict_types=1);

namespace Blog\Database\Type;

use DateTime as PhpDateTime;
use Blog\Core\DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TimeType as DoctrineTimeType;

final class TimeType extends DoctrineTimeType
{
    private const NAME = 'time';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getTimeTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTime
    {
        if ($value === null || $value instanceof DateTime) {
            return $value;
        }

        $dateMutable = PhpDateTime::createFromFormat('!' . $platform->getTimeFormatString(), $value);

        if ($dateMutable !== false) {
            $val = DateTime::fromPhpDateTime($dateMutable);
        } else {
            $val = (new DateTime((string)$value))->setDate(1970, 1, 1);
        }

        return $val;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value !== null) {
            return $value->format($platform->getTimeFormatString());
        }
        return null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
