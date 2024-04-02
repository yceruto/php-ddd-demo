<?php

namespace App\Project\Task\Domain\Model;

use App\Shared\Domain\Error\InvalidArgument;
use App\Shared\Domain\Model\NonEmptyString;

final readonly class TaskTitle extends NonEmptyString
{
    public static function from(string $value): static
    {
        if (strlen($value) <= 3) {
            throw InvalidArgument::from('Task title must be greater than 3 characters.');
        }

        if (strlen($value) > 100) {
            throw InvalidArgument::from('Task title must be less than 100 characters.');
        }

        return parent::from($value);
    }
}
