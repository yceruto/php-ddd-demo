<?php

namespace App\Shared\Domain\Model;

use App\Shared\Domain\Error\InvalidArgument;

readonly class NonEmptyString implements \Stringable
{
    public static function from(string $value): static
    {
        return new static($value);
    }

    public function equals(self $string): bool
    {
        return $this->value === $string->value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    final private function __construct(
        private string $value,
    ) {
        if ('' === $value) {
            throw InvalidArgument::from('The string value must not be empty.');
        }
    }
}
