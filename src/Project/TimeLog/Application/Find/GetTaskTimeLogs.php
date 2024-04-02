<?php

namespace App\Project\TimeLog\Application\Find;

final readonly class GetTaskTimeLogs
{
    public function __construct(
        public string $taskId,
    ) {
    }
}
