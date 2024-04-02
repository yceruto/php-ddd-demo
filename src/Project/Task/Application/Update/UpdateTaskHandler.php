<?php

namespace App\Project\Task\Application\Update;

use App\Project\Task\Domain\Model\Props\UpdateTaskProps;
use App\Project\Task\Domain\Model\TaskId;

/**
 * Command handler to update a task.
 */
final readonly class UpdateTaskHandler
{
    public function __construct(
        private TaskUpdater $updater,
    ) {
    }

    public function handle(UpdateTask $command): void
    {
        $this->updater->update(
            TaskId::from($command->id),
            UpdateTaskProps::from($command->title, $command->description),
        );
    }
}
