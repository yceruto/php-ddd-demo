<?php

namespace App\Tests\Project\TimeLog\Application\Create;

use App\Project\Task\Application\Find\TaskFinder;
use App\Project\Task\Domain\Model\TaskId;
use App\Project\Task\Infrastructure\Persistence\InMemory\InMemoryTaskRepository;
use App\Project\TimeLog\Application\Create\TimeLogCreator;
use App\Project\TimeLog\Domain\Model\Props\CreateTimeLogProps;
use App\Project\TimeLog\Domain\Model\TimeLogId;
use App\Project\TimeLog\Infrastructure\Persistence\InMemory\InMemoryTimeLogRepository;
use App\Tests\Project\Task\Domain\Model\TaskMother;
use PHPUnit\Framework\TestCase;

class TimeLogCreatorTest extends TestCase
{
    public function testLogTime(): void
    {
        $task = TaskMother::default();
        $taskRepository = new InMemoryTaskRepository([$task]);
        $taskFinder = new TaskFinder($taskRepository);
        $timeLogRepository = new InMemoryTimeLogRepository();
        $timeLogCreator = new TimeLogCreator($taskFinder, $timeLogRepository);

        $props = CreateTimeLogProps::from(TimeLogId::raw(), 'Work', 'PT1H');
        $taskId = TaskId::from('84080b1a-2806-49bf-b413-aebc7c141c29');
        $timeLog = $timeLogCreator->create($props, $taskId);

        self::assertCount(1, $timeLogRepository->ofTaskId($taskId));
        self::assertSame('1 hour', $timeLog->duration()->toDisplay());
        self::assertSame('1 hour', $task->duration()->toDisplay());
    }
}
