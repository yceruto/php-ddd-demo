<?php

namespace App\Project\Task\Application\Update;

final readonly class UpdateTaskStatus
{
    public function __construct(
        public string $id,
        public string $status,
    ) {
    }
}
