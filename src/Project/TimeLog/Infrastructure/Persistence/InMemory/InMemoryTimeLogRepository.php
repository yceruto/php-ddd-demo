<?php

namespace App\Project\TimeLog\Infrastructure\Persistence\InMemory;

use App\Project\Task\Domain\Model\TaskId;
use App\Project\TimeLog\Domain\Model\TimeLog;
use App\Project\TimeLog\Domain\Model\TimeLogId;
use App\Project\TimeLog\Domain\Repository\TimeLogRepository;

class InMemoryTimeLogRepository implements TimeLogRepository
{
    /**
     * @var array<string, TimeLog>
     */
    public array $timeLogs = [];

    /**
     * @param iterable<TimeLog> $timeLogs
     */
    public function __construct(iterable $timeLogs = [])
    {
        foreach ($timeLogs as $timeLog) {
            $this->add($timeLog);
        }
    }

    public function add(TimeLog $timeLog): void
    {
        $this->timeLogs[$timeLog->id()->toString()] = $timeLog;
    }

    public function remove(TimeLog $timeLog): void
    {
        unset($this->timeLogs[$timeLog->id()->toString()]);
    }

    public function ofId(TimeLogId $id): ?TimeLog
    {
        return $this->timeLogs[$id->toString()] ?? null;
    }

    public function ofTaskId(TaskId $taskId): iterable
    {
        return array_filter(
            $this->timeLogs,
            static fn (TimeLog $timeLog) => $timeLog->taskId()->equals($taskId),
        );
    }
}
