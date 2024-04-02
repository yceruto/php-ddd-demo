<?php

namespace App\Project\Task\Domain\Model\Props;

use App\Project\Task\Domain\Model\TaskDescription;
use App\Project\Task\Domain\Model\TaskTitle;

final readonly class UpdateTaskProps
{
    public static function from(string $title, string $description): self
    {
        return new self(
            TaskTitle::from($title),
            TaskDescription::from($description),
        );
    }

    private function __construct(
        public TaskTitle $title,
        public TaskDescription $description,
    ) {
    }
}
