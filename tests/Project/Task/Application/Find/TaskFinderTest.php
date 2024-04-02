<?php

namespace App\Tests\Project\Task\Application\Find;

use App\Project\Task\Application\Find\TaskFinder;
use App\Project\Task\Domain\Error\TaskNotFound;
use App\Project\Task\Domain\Model\TaskId;
use App\Project\Task\Infrastructure\Persistence\InMemory\InMemoryTaskRepository;
use App\Tests\Project\Task\Domain\Model\TaskMother;
use PHPUnit\Framework\TestCase;

class TaskFinderTest extends TestCase
{
    public function testFindOne(): void
    {
        $repository = new InMemoryTaskRepository();
        $repository->add($taskDefault = TaskMother::default());
        $finder = new TaskFinder($repository);

        $taskFound = $finder->findOne(TaskId::from('84080b1a-2806-49bf-b413-aebc7c141c29'));

        self::assertTrue($taskDefault->equals($taskFound));
    }

    public function testFindAll(): void
    {
        $repository = new InMemoryTaskRepository();
        $repository->add($taskDefault = TaskMother::default());
        $finder = new TaskFinder($repository);

        $tasksFound = $finder->findAll();

        self::assertCount(1, $tasksFound);
        self::assertTrue($taskDefault->equals($tasksFound[0]));
    }

    public function testTaskNotFound(): void
    {
        $repository = new InMemoryTaskRepository();
        $finder = new TaskFinder($repository);

        $this->expectException(TaskNotFound::class);
        $this->expectExceptionMessage('Task with id 84080b1a-2806-49bf-b413-aebc7c141c29 not found.');

        $finder->findOne(TaskId::from('84080b1a-2806-49bf-b413-aebc7c141c29'));
    }
}
