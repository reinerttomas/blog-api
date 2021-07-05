<?php
declare(strict_types=1);

namespace Blog\Core;

use DateTime as PhpDateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Blog\Exception\Exception;

class DateTime extends DateTimeImmutable
{
    public function __construct(string $time = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
    }

    public function __toString(): string
    {
        return $this->format('Y-m-d H:i:s');
    }

    public function toPhpDateTime(): PhpDateTime
    {
        return new PhpDateTime($this->format('Y-m-d H:i:s'));
    }

    public function setTimeStartOfDay(): DateTime
    {
        return $this->setTime(0, 0, 0, 0);
    }

    public function setTimeEndOfDay(): DateTime
    {
        return $this->setTime(23, 59, 59, 999);
    }

    public function isDateTimeSame(DateTime $dateTime): bool
    {
        if ($this->format('Y-m-d H:i:s') === $dateTime->format('Y-m-d H:i:s')) {
            return true;
        }

        return false;
    }

    public static function fromPhpDateTime(DateTimeInterface $dateTime): DateTime
    {
        return new DateTime($dateTime->format('Y-m-d H:i:s.u'));
    }

    public static function fromPhpDateTimeOrNull(?PhpDateTime $dateTime = null): ?DateTime
    {
        if ($dateTime === null) {
            return null;
        }

        return new DateTime($dateTime->format('Y-m-d H:i:s.u'));
    }

    public static function fromFormat(string $format, string $dateTime): DateTime
    {
        $date = parent::createFromFormat($format, $dateTime);

        if ($date === false) {
            throw new Exception('Format: ' . $format . ' date string ' . $dateTime);
        }

        return new DateTime($date->format('Y-m-d H:i:s.u'));
    }

    public function isDateToday(): bool
    {
        $today = (new DateTime())->format('Y-m-d');

        if ($this->format('Y-m-d') === $today) {
            return true;
        }

        return false;
    }

    public function getDayOfWeek(): int
    {
        $dayOfWeek = intval($this->format('N'));
        if ($dayOfWeek === 0) {
            throw new Exception('Error day of week');
        }

        return $dayOfWeek;
    }

    public function isMonday(): bool
    {
        return $this->getDayOfWeek() === 1;
    }

    public function isTuesday(): bool
    {
        return $this->getDayOfWeek() === 2;
    }

    public function isWednesday(): bool
    {
        return $this->getDayOfWeek() === 3;
    }

    public function isThursday(): bool
    {
        return $this->getDayOfWeek() === 4;
    }

    public function isFriday(): bool
    {
        return $this->getDayOfWeek() === 5;
    }

    public function isSaturday(): bool
    {
        return $this->getDayOfWeek() === 6;
    }

    public function isSunday(): bool
    {
        return $this->getDayOfWeek() === 7;
    }
}
