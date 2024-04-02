<?php

namespace App\Tests\Project\TimeLog\Application\Delete;

use App\Project\Task\Application\Find\TaskFinder;
use App\Project\Task\Infrastructure\Persistence\InMemory\InMemoryTaskRepository;
use App\Project\TimeLog\Application\Delete\TimeLogDeleter;
use App\Project\TimeLog\Application\Find\TimeLogFinder;
use App\Project\TimeLog\Domain\Model\Props\CreateTimeLogProps;
use App\Project\TimeLog\Domain\Model\TimeLogId;
use App\Project\TimeLog\Infrastructure\Persistence\InMemory\InMemoryTimeLogRepository;
use App\Tests\Project\Task\Domain\Model\TaskMother;
use PHPUnit\Framework\TestCase;

class TimeLogDeleterTest extends TestCase
{
    public function testDelete(): void
    {
        $task = TaskMother::default();
        $timeLogId = TimeLogId::from('84080b1a-2806-49bf-b413-aebc7c141c23');
        $timeLog = $task->newTimeLog(CreateTimeLogProps::from($timeLogId, 'Work', 'PT1H'));
        $taskRepository = new InMemoryTaskRepository([$task]);
        $taskFinder = new TaskFinder($taskRepository);
        $timeLogRepository = new InMemoryTimeLogRepository([$timeLog]);
        $timeLogFinder = new TimeLogFinder($timeLogRepository);
        $timeLogDeleter = new TimeLogDeleter($taskFinder, $timeLogFinder, $timeLogRepository);

        $timeLogDeleter->delete($timeLogId);

        self::assertCount(0, $timeLogRepository->ofTaskId($task->id()));
        self::assertTrue($task->duration()->isZero());
    }
}
