<?php

namespace App\Tests\Project\Task\Application\Create;

use App\Project\Task\Application\Create\TaskCreator;
use App\Project\Task\Domain\Model\Props\CreateTaskProps;
use App\Project\Task\Infrastructure\Persistence\InMemory\InMemoryTaskRepository;
use PHPUnit\Framework\TestCase;

class TaskCreatorTest extends TestCase
{
    public function testCreate(): void
    {
        $repository = new InMemoryTaskRepository();
        $creator = new TaskCreator($repository);

        self::assertCount(0, $repository->all());

        $task = $creator->create(
            CreateTaskProps::from(
                id: '84080b1a-2806-49bf-b413-aebc7c141c29',
                title: 'Task 1',
                description: 'Description 1',
            ),
        );

        self::assertEquals('84080b1a-2806-49bf-b413-aebc7c141c29', $task->id());
        self::assertCount(1, $repository->all());
    }
}
