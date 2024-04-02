<?php

namespace App\Project\Task\Domain\Model;

use App\Shared\Domain\Error\InvalidArgument;
use App\Shared\Domain\Model\NonEmptyString;

final readonly class TaskDescription extends NonEmptyString
{
    public static function from(string $value): static
    {
        if (strlen($value) > 255) {
            throw InvalidArgument::from('Task description must be less than 255 characters.');
        }

        return parent::from($value);
    }
}
