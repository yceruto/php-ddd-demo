<?php

namespace App\Project\Task\Application\Update;

use App\Project\Task\Domain\Model\TaskId;
use App\Project\Task\Domain\Model\TaskStatus;

final readonly class UpdateTaskStatusHandler
{
    public function __construct(
        private TaskUpdater $updater,
    ) {
    }

    public function __invoke(UpdateTaskStatus $command): void
    {
        $this->updater->updateStatus(
            TaskId::from($command->id),
            TaskStatus::from($command->status),
        );
    }
}
