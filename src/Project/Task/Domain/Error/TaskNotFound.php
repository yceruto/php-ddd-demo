<?php

namespace App\Project\Task\Domain\Error;

use App\Project\Task\Domain\Model\TaskId;
use App\Shared\Domain\Error\EntityNotFound;

final class TaskNotFound extends EntityNotFound
{
    public static function fromId(TaskId $id): self
    {
        return parent::from(sprintf('Task with id %s not found.', $id->toString()));
    }
}
