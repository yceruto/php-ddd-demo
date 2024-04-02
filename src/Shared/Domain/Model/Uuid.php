<?php

namespace App\Shared\Domain\Model;

use App\Shared\Domain\Error\InvalidArgument;

readonly class Uuid implements \Stringable
{
    public static function new(): static
    {
        return new static(uuid_create(UUID_TYPE_RANDOM));
    }

    public static function from(string $value): static
    {
        if ('' === $value) {
            throw InvalidArgument::from('The UUID value must not be empty.');
        }

        uuid_is_valid($value) || throw InvalidArgument::from('The UUID value is not valid.');

        return new static($value);
    }

    public static function raw(): string
    {
        return uuid_create(UUID_TYPE_RANDOM);
    }

    public function equals(self $uuid): bool
    {
        return $this->value === $uuid->value;
    }

    public function notEquals(self $uuid): bool
    {
        return $this->value !== $uuid->value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    final private function __construct(
        private string $value,
    ) {
    }
}
