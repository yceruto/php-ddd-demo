<?php

namespace App\Project\Task\Application\Update;

use App\Project\Task\Application\Find\TaskFinder;
use App\Project\Task\Domain\Model\Props\UpdateTaskProps;
use App\Project\Task\Domain\Model\Task;
use App\Project\Task\Domain\Model\TaskId;
use App\Project\Task\Domain\Model\TaskStatus;

/**
 * Service to update a task.
 */
final readonly class TaskUpdater
{
    public function __construct(
        private TaskFinder $finder,
    ) {
    }

    public function update(TaskId $id, UpdateTaskProps $props): Task
    {
        $task = $this->finder->findOne($id);
        $task->update($props);

        return $task;
    }

    public function updateStatus(TaskId $id, TaskStatus $newStatus): Task
    {
        $task = $this->finder->findOne($id);
        $task->changeStatus($newStatus);

        return $task;
    }
}
