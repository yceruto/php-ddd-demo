<?php

namespace App\Project\Task\Application\Find;

/**
 * Query message to find a task.
 */
final readonly class FindTask
{
    public function __construct(
        public string $id,
    ) {
    }
}
