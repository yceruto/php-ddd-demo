<?php

namespace App\Project\Task\Domain\Model;

use App\Project\Task\Domain\Error\InvalidTaskStatus;
use App\Project\Task\Domain\Event\TaskCreated;
use App\Project\Task\Domain\Event\TaskTimeLogAdded;
use App\Project\Task\Domain\Event\TaskTimeLogUndone;
use App\Project\Task\Domain\Event\TaskUpdated;
use App\Project\Task\Domain\Model\Props\CreateTaskProps;
use App\Project\Task\Domain\Model\Props\UpdateTaskProps;
use App\Project\TimeLog\Domain\Model\Props\CreateTimeLogProps;
use App\Project\TimeLog\Domain\Model\TimeLog;
use App\Shared\Domain\Error\InvalidArgument;
use App\Shared\Domain\Model\AggregateRoot;

final class Task
{
    use AggregateRoot;

    public static function new(CreateTaskProps $props): self
    {
        $task = new self(
            $props->id,
            $props->title,
            $props->description,
            TaskStatus::PROPOSAL,
            TaskDuration::zero(),
            new \DateTimeImmutable(),
        );
        $task->pushDomainEvent(TaskCreated::new($props->id));

        return $task;
    }

    public function update(UpdateTaskProps $props): void
    {
        $this->title = $props->title;
        $this->description = $props->description;
        $this->pushUpdatedEvent();
    }

    public function id(): TaskId
    {
        return $this->id;
    }

    public function title(): TaskTitle
    {
        return $this->title;
    }

    public function description(): TaskDescription
    {
        return $this->description;
    }

    public function status(): TaskStatus
    {
        return $this->status;
    }

    public function changeStatus(TaskStatus $status): void
    {
        if (!$this->status->canApply($status)) {
            throw InvalidTaskStatus::from(sprintf('Invalid status change from "%s" to "%s".', $this->status->value, $status->value));
        }

        $this->status = $status;
        $this->pushUpdatedEvent();
    }

    public function duration(): TaskDuration
    {
        return $this->duration;
    }

    public function newTimeLog(CreateTimeLogProps $props): TimeLog
    {
        if ($props->duration->isZero()) {
            throw InvalidArgument::from('The time log duration must be greater than zero.');
        }

        $timeLog = TimeLog::new($props, $this->id);
        $this->duration = $this->duration->add($timeLog->duration());
        $this->pushDomainEvent(TaskTimeLogAdded::new($this->id));
        $this->pushUpdatedEvent();

        return $timeLog;
    }

    public function undoTimeLog(TimeLog $timeLog): void
    {
        if ($timeLog->taskId()->notEquals($this->id)) {
            throw InvalidArgument::from('The time log does not belong to this task.');
        }

        if ($timeLog->duration()->isZero()) {
            return;
        }

        $this->duration = $this->duration->subtract($timeLog->duration());
        $this->pushDomainEvent(TaskTimeLogUndone::new($this->id));
        $this->pushUpdatedEvent();
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function equals(self $other): bool
    {
        return $this->id->equals($other->id)
            && $this->title->equals($other->title)
            && $this->description->equals($other->description)
            && $this->status->equals($other->status);
    }

    protected function pushUpdatedEvent(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
        $this->pushDomainEvent(TaskUpdated::new($this->id));
    }

    protected function __construct(
        private readonly TaskId $id,
        private TaskTitle $title,
        private TaskDescription $description,
        private TaskStatus $status,
        private TaskDuration $duration,
        private readonly \DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
    }
}
