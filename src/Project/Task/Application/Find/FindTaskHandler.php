<?php

namespace App\Project\Task\Application\Find;

use App\Project\Task\Domain\Model\Task;
use App\Project\Task\Domain\Model\TaskId;

/**
 * Query handler to find a task.
 */
final readonly class FindTaskHandler
{
    public function __construct(
        private TaskFinder $finder,
    ) {
    }

    public function handle(FindTask $query): Task
    {
        return $this->finder->findOne(TaskId::from($query->id));
    }
}
