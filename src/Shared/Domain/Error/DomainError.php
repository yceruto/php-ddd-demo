<?php

namespace App\Shared\Domain\Error;

class DomainError extends \DomainException
{
    /**
     * @param non-empty-string $message
     */
    public static function from(string $message, int $code = 0): static
    {
        return new static($message, $code);
    }

    final private function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
