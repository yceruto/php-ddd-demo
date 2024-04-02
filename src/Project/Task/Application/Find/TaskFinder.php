<?php

namespace App\Project\Task\Application\Find;

use App\Project\Task\Domain\Error\TaskNotFound;
use App\Project\Task\Domain\Model\Task;
use App\Project\Task\Domain\Model\TaskId;
use App\Project\Task\Domain\Repository\TaskRepository;

/**
 * Task finder service.
 */
final readonly class TaskFinder
{
    public function __construct(
        private TaskRepository $repository,
    ) {
    }

    /**
     * @throws TaskNotFound
     */
    public function findOne(TaskId $id): Task
    {
        return $this->repository->ofId($id) ?? throw TaskNotFound::fromId($id);
    }

    /**
     * @return iterable<Task>
     */
    public function findAll(): iterable
    {
        return $this->repository->all();
    }
}
