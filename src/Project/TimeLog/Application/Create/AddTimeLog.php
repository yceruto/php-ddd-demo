<?php

namespace App\Project\TimeLog\Application\Create;

/**
 * Command message to add a new time log.
 */
final readonly class AddTimeLog
{
    public function __construct(
        public string $id,
        public string $description,
        public string $duration,
        public string $taskId,
    ) {
    }
}
