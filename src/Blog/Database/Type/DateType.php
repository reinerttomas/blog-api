<?php
declare(strict_types=1);

namespace Blog\Database\Type;

use DateTime as PhpDateTime;
use Blog\Core\DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType as DoctrineDateType;

final class DateType extends DoctrineDateType
{
    private const NAME = 'date';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getDateTimeTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTime
    {
        if ($value === null || $value instanceof DateTime) {
            return $value;
        }

        $dateMutable = PhpDateTime::createFromFormat($platform->getDateFormatString(), $value);

        if ($dateMutable !== false) {
            $val = DateTime::fromPhpDateTime($dateMutable);
        } else {
            $val = new DateTime((string)$value);
        }

        return $val->setTime(0, 0, 0, 0);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value !== null) {
            return $value->format($platform->getDateFormatString());
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
