<?php

namespace App\Project\TimeLog\Application\Delete;

/**
 * Command message to undo a time log.
 */
final readonly class UndoTimeLog
{
    public function __construct(
        public string $id,
    ) {
    }
}
