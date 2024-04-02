<?php

namespace App\Project\TimeLog\Domain\Model;

use App\Shared\Domain\Error\InvalidArgument;
use App\Shared\Domain\Model\NonEmptyString;

final readonly class TimeLogDescription extends NonEmptyString
{
    public static function from(string $value): static
    {
        if (strlen($value) > 255) {
            throw InvalidArgument::from('Time log description must be less than 255 characters.');
        }

        return parent::from($value);
    }
}
