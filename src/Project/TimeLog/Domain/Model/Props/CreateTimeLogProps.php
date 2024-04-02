<?php

namespace App\Project\TimeLog\Domain\Model\Props;

use App\Project\TimeLog\Domain\Model\TimeLogDescription;
use App\Project\TimeLog\Domain\Model\TimeLogDuration;
use App\Project\TimeLog\Domain\Model\TimeLogId;

final readonly class CreateTimeLogProps
{
    public static function from(string $id, string $description, string $duration): self
    {
        return new self(
            TimeLogId::from($id),
            TimeLogDescription::from($description),
            TimeLogDuration::from($duration),
        );
    }

    private function __construct(
        public TimeLogId $id,
        public TimeLogDescription $description,
        public TimeLogDuration $duration,
    ) {
    }
}
