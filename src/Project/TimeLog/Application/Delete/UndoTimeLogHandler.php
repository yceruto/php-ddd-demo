<?php

namespace App\Project\TimeLog\Application\Delete;

use App\Project\TimeLog\Domain\Model\TimeLogId;

/**
 * Command handler to undo a time log.
 */
final readonly class UndoTimeLogHandler
{
    public function __construct(
        private TimeLogDeleter $deleter,
    ) {
    }

    public function handle(UndoTimeLog $command): void
    {
        $this->deleter->delete(TimeLogId::from($command->id));
    }
}
