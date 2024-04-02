<?php

namespace App\Tests\Project\Task\Application\Update;

use App\Project\Task\Application\Find\TaskFinder;
use App\Project\Task\Application\Update\TaskUpdater;
use App\Project\Task\Domain\Model\Props\UpdateTaskProps;
use App\Project\Task\Domain\Model\TaskId;
use App\Project\Task\Infrastructure\Persistence\InMemory\InMemoryTaskRepository;
use App\Tests\Project\Task\Domain\Model\TaskMother;
use PHPUnit\Framework\TestCase;

class TaskUpdaterTest extends TestCase
{
    public function testUpdate(): void
    {
        $repository = new InMemoryTaskRepository();
        $repository->add(TaskMother::default());
        $finder = new TaskFinder($repository);
        $updater = new TaskUpdater($finder);

        $taskUpdated = $updater->update(
            TaskId::from('84080b1a-2806-49bf-b413-aebc7c141c29'),
            UpdateTaskProps::from(
                title: 'Task X',
                description: 'Description X',
            ),
        );

        self::assertFalse($taskUpdated->equals(TaskMother::default()));
    }
}
