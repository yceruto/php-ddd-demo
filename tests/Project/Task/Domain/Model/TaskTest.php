<?php

namespace App\Tests\Project\Task\Domain\Model;

use App\Project\Task\Domain\Error\InvalidTaskStatus;
use App\Project\Task\Domain\Model\Props\CreateTaskProps;
use App\Project\Task\Domain\Model\Props\UpdateTaskProps;
use App\Project\Task\Domain\Model\Task;
use App\Project\Task\Domain\Model\TaskStatus;
use App\Project\TimeLog\Domain\Model\Props\CreateTimeLogProps;
use App\Project\TimeLog\Domain\Model\TimeLogId;
use App\Shared\Domain\Error\InvalidArgument;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testDefaults(): void
    {
        $task = Task::new(
            CreateTaskProps::from(
                id: '84080b1a-2806-49bf-b413-aebc7c141c29',
                title: 'Task 1',
                description: 'Description 1',
            )
        );

        self::assertSame('84080b1a-2806-49bf-b413-aebc7c141c29', $task->id()->toString());
        self::assertSame('Task 1', $task->title()->toString());
        self::assertSame('Description 1', $task->description()->toString());
        self::assertTrue($task->status()->isProposal());
        self::assertGreaterThanOrEqual(time(), $task->createdAt()->getTimestamp());
        self::assertNull($task->updatedAt());
    }

    public function testUpdateTitleAndDescription(): void
    {
        $task = TaskMother::default();

        self::assertSame('Task 1', $task->title()->toString());
        self::assertSame('Description 1', $task->description()->toString());

        $task->update(
            UpdateTaskProps::from(
                title: 'Task 2',
                description: 'Description 2',
            )
        );

        self::assertSame('Task 2', $task->title()->toString());
        self::assertSame('Description 2', $task->description()->toString());
        self::assertGreaterThanOrEqual(time(), $task->updatedAt()->getTimestamp());
    }

    public function testChangeStatus(): void
    {
        $task = TaskMother::default();

        self::assertTrue($task->status()->isProposal());

        $task->changeStatus(TaskStatus::TODO);

        self::assertTrue($task->status()->isTodo());

        $task->changeStatus(TaskStatus::IN_PROGRESS);

        self::assertTrue($task->status()->isInProgress());

        $task->changeStatus(TaskStatus::DONE);

        self::assertTrue($task->status()->isDone());
    }

    public function testChangeStatusWithInvalidStatus(): void
    {
        $task = TaskMother::default();

        $this->expectException(InvalidTaskStatus::class);
        $this->expectExceptionMessage('Invalid status change from "proposal" to "done".');

        $task->changeStatus(TaskStatus::DONE);
    }

    public function testEquality(): void
    {
        $task1 = TaskMother::default();
        $task2 = TaskMother::default();

        self::assertTrue($task1->equals($task2));

        $task2->update(
            UpdateTaskProps::from(
                title: 'Task 2',
                description: 'Description 2',
            )
        );

        self::assertFalse($task1->equals($task2));
    }

    public function testLogTime(): void
    {
        $task = TaskMother::default();
        self::assertTrue($task->duration()->isZero());

        $timeLog = $task->newTimeLog(CreateTimeLogProps::from(TimeLogId::raw(), 'Work', 'PT1H'));
        self::assertSame('1 hour', $timeLog->duration()->toDisplay());
        self::assertSame('1 hour', $task->duration()->toDisplay());

        $timeLog = $task->newTimeLog(CreateTimeLogProps::from(TimeLogId::raw(), 'Work', 'PT15M'));
        self::assertSame('15 minutes', $timeLog->duration()->toDisplay());
        self::assertSame('1 hour, 15 minutes', $task->duration()->toDisplay());
    }

    public function testLogTimeWithZeroDuration(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('The time log duration must be greater than zero.');

        $task = TaskMother::default();
        $task->newTimeLog(CreateTimeLogProps::from(TimeLogId::raw(), 'Work', 'PT0S'));
    }

    public function testUndoTimeLog(): void
    {
        $task = TaskMother::default();
        $timeLog1 = $task->newTimeLog(CreateTimeLogProps::from(TimeLogId::raw(), 'Work', 'PT1H'));
        $timeLog2 = $task->newTimeLog(CreateTimeLogProps::from(TimeLogId::raw(), 'Work', 'PT15M'));

        self::assertSame('1 hour, 15 minutes', $task->duration()->toDisplay());

        $task->undoTimeLog($timeLog2);

        self::assertSame('1 hour', $task->duration()->toDisplay());

        $task->undoTimeLog($timeLog1);

        self::assertTrue($task->duration()->isZero());
    }
}
