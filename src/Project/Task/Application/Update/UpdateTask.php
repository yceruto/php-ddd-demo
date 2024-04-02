<?php

namespace App\Project\Task\Application\Update;

/**
 * Command message to update a task.
 */
final readonly class UpdateTask
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
    ) {
    }
}
