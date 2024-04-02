<?php

namespace App\Project\Task\Domain\Model\Props;

use App\Project\Task\Domain\Model\TaskDescription;
use App\Project\Task\Domain\Model\TaskId;
use App\Project\Task\Domain\Model\TaskTitle;

final readonly class CreateTaskProps
{
    public static function from(string $id, string $title, string $description): self
    {
        return new self(
            TaskId::from($id),
            TaskTitle::from($title),
            TaskDescription::from($description),
        );
    }

    private function __construct(
        public TaskId $id,
        public TaskTitle $title,
        public TaskDescription $description,
    ) {
    }
}
