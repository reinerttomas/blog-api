<?php
declare(strict_types=1);

namespace Blog\Core\StopWatch;

use Symfony\Component\Stopwatch\Stopwatch as SymfonyStopWatch;

class StopWatch
{
    private SymfonyStopWatch $stopWatch;

    public function __construct()
    {
        $this->stopWatch = new SymfonyStopWatch();
    }

    public function start(string $name): StopWatch
    {
        $this->stopWatch->start($name);

        return $this;
    }

    public function stop(string $name): StopWatchResponse
    {
        $this->stopWatch->stop($name);
        $event = $this->stopWatch->getEvent($name);

        return new StopWatchResponse($event);
    }

    public function lap(string $name): StopWatchResponse
    {
        $lap = $this->stopWatch->lap($name);

        return new StopWatchResponse($lap);
    }

    public function lapWithReset(string $name): StopWatchResponse
    {
        $lap = $this->stopWatch->lap($name);
        $this->stopWatch->reset();
        $this->stopWatch->start($name);

        return new StopWatchResponse($lap);
    }
}
