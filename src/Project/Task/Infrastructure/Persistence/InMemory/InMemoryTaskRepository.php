<?php

namespace App\Project\Task\Infrastructure\Persistence\InMemory;

use App\Project\Task\Domain\Model\Task;
use App\Project\Task\Domain\Model\TaskId;
use App\Project\Task\Domain\Repository\TaskRepository;

class InMemoryTaskRepository implements TaskRepository
{
    /**
     * @var array<string, Task>
     */
    private array $tasks = [];

    /**
     * @param iterable<Task> $tasks
     */
    public function __construct(iterable $tasks = [])
    {
        foreach ($tasks as $task) {
            $this->add($task);
        }
    }

    public function add(Task $task): void
    {
        $this->tasks[$task->id()->toString()] = $task;
    }

    public function ofId(TaskId $id): ?Task
    {
        return $this->tasks[$id->toString()] ?? null;
    }

    /**
     * @return iterable<Task>
     */
    public function all(): iterable
    {
        return array_values($this->tasks);
    }
}
