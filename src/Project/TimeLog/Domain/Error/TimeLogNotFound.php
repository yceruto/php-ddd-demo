<?php

namespace App\Project\TimeLog\Domain\Error;

use App\Project\TimeLog\Domain\Model\TimeLogId;
use App\Shared\Domain\Error\EntityNotFound;

final class TimeLogNotFound extends EntityNotFound
{
    public static function fromId(TimeLogId $id): self
    {
        return parent::from(sprintf('Time log with id %s not found.', $id->toString()));
    }
}
