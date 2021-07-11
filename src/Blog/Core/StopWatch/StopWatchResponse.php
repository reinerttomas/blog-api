<?php
declare(strict_types=1);

namespace Blog\Core\StopWatch;

use Blog\Core\Math;
use Blog\Exception\Exception;
use Symfony\Component\Stopwatch\StopwatchEvent;

class StopWatchResponse
{
    public const DURATION_MILLISECOND = 'ms';
    public const DURATION_SECOND = 's';
    public const DURATION_MINUTE = 'i';

    public const MEMORY_BYTES = 'byte';
    public const MEMORY_KILO_BYTES = 'kilobyte';
    public const MEMORY_MEGA_BYTES = 'megabyte';

    private StopwatchEvent $event;

    public function __construct(StopwatchEvent $event)
    {
        $this->event = $event;
    }

    public function getDuration(?string $timeFormat = self::DURATION_SECOND, int $roundNumbers = 2): float
    {
        $duration = $this->event->getDuration();

        if ($timeFormat === self::DURATION_MILLISECOND) {
            $totalDuration = $duration;
        } elseif ($timeFormat === self::DURATION_SECOND) {
            $totalDuration = $duration / 1000;
        } elseif ($timeFormat === self::DURATION_MINUTE) {
            $totalDuration = $duration / 1000 / 60;
        } else {
            throw new Exception('Time format not exist');
        }

        return Math::round($totalDuration, $roundNumbers);
    }

    public function getMemory(?string $memoryFormat = self::MEMORY_MEGA_BYTES, int $roundNumbers = 2): float
    {
        $memory = $this->event->getMemory();

        if ($memoryFormat === self::MEMORY_BYTES) {
            $totalMemory = $memory;
        } elseif ($memoryFormat === self::MEMORY_KILO_BYTES) {
            $totalMemory = $memory / 1024;
        } elseif ($memoryFormat === self::MEMORY_MEGA_BYTES) {
            $totalMemory = $memory / 1024 / 1024;
        } else {
            throw new Exception('Memory format not exist');
        }

        return Math::round($totalMemory, $roundNumbers);
    }

    public function getDurationMemoryMessage(): string
    {
        $this->getDuration();
        $message = \PHP_EOL . 'Duration: ' . $this->getDuration() . ' seconds' . \PHP_EOL;
        $message .= 'Memory: ' . $this->getMemory() . ' MB';

        return $message;
    }
}
