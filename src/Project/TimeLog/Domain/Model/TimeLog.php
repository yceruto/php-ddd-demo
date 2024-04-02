<?php

namespace App\Project\TimeLog\Domain\Model;

use App\Project\Task\Domain\Model\TaskId;
use App\Project\TimeLog\Domain\Event\TimeLogCreated;
use App\Project\TimeLog\Domain\Model\Props\CreateTimeLogProps;
use App\Shared\Domain\Model\AggregateRoot;

final class TimeLog
{
    use AggregateRoot;

    public static function new(CreateTimeLogProps $props, TaskId $taskId): self
    {
        $timeLog = new self(
            $props->id,
            $props->description,
            $props->duration,
            $taskId,
            new \DateTimeImmutable(),
        );
        $timeLog->pushDomainEvent(TimeLogCreated::new($props->id));

        return $timeLog;
    }

    public function id(): TimeLogId
    {
        return $this->id;
    }

    public function description(): TimeLogDescription
    {
        return $this->description;
    }

    public function duration(): TimeLogDuration
    {
        return $this->duration;
    }

    public function taskId(): TaskId
    {
        return $this->taskId;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    private function __construct(
        private readonly TimeLogId $id,
        private readonly TimeLogDescription $description,
        private readonly TimeLogDuration $duration,
        private readonly TaskId $taskId,
        private readonly \DateTimeImmutable $createdAt,
    ) {
    }
}
