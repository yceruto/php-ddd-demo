<?php

namespace App\Project\TimeLog\Application\Find;

/**
 * Query message to find a time log.
 */
final readonly class FindTimeLog
{
    public function __construct(
        public string $id,
    ) {
    }
}
