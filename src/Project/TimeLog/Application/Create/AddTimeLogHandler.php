<?php

namespace App\Project\TimeLog\Application\Create;

use App\Project\Task\Domain\Model\TaskId;
use App\Project\TimeLog\Domain\Model\Props\CreateTimeLogProps;

/**
 * Command handler to add a time log.
 */
final readonly class AddTimeLogHandler
{
    public function __construct(
        private TimeLogCreator $creator
    ) {
    }

    public function handle(AddTimeLog $command): void
    {
        $this->creator->create(
            CreateTimeLogProps::from(
                $command->id,
                $command->description,
                $command->duration
            ),
            TaskId::from($command->taskId),
        );
    }
}
