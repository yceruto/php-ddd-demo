<?php

namespace App\Project\Task\Application\Create;

use App\Project\Task\Domain\Model\Props\CreateTaskProps;
use App\Project\Task\Domain\Model\Task;
use App\Project\Task\Domain\Repository\TaskRepository;

/**
 * Task creator service.
 *
 * Properties:
 *  - Stateless
 *  - Execute business logic
 *  - Use domain entities and value objects
 */
final readonly class TaskCreator
{
    public function __construct(
        private TaskRepository $repository,
    ) {
    }

    public function create(CreateTaskProps $props): Task
    {
        $task = Task::new($props);

        $this->repository->add($task);

        return $task;
    }
}
