<?php

namespace App\Project\Task\Domain\Repository;

use App\Project\Task\Domain\Model\Task;
use App\Project\Task\Domain\Model\TaskId;

interface TaskRepository
{
    public function add(Task $task): void;

    public function ofId(TaskId $id): ?Task;

    /**
     * @return iterable<Task>
     */
    public function all(): iterable;
}
