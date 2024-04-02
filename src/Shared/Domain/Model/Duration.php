<?php

namespace App\Shared\Domain\Model;

readonly class Duration
{
    public static function new(\DateInterval $value): static
    {
        return new static($value);
    }

    public static function from(string $duration): static
    {
        return new static(new \DateInterval($duration));
    }

    public static function zero(): static
    {
        return new static(new \DateInterval('PT0S'));
    }

    public function isZero(): bool
    {
        return '' === $this->toDisplay();
    }

    public function value(): \DateInterval
    {
        return $this->value;
    }

    public function add(self $other): static
    {
        $base = new \DateTimeImmutable('2000-01-01 00:00:00');

        return new static($base->diff($base->add($this->value)->add($other->value)));
    }

    public function subtract(self $other): static
    {
        $base = new \DateTimeImmutable('2000-01-01 00:00:00');
        $end1 = $base->add($this->value);

        $end2 = $base->add($other->value);
        if ($end1 >= $end2) {
            $result = $end2->diff($end1);
        } else {
            $result = $end1->diff($end2);
            $result->invert = 1;
        }

        return new static($result);
    }

    public function toString(): string
    {
        return $this->value->format('%rP%yY%mM%dDT%hH%iM%sS');
    }

    public function toDisplay(): string
    {
        $parts = [];
        $sign = 1 === $this->value->invert ? '-' : '';
        if (0 !== $this->value->y) {
            $parts[] = $this->value->y.' year'.(abs($this->value->y) > 1 ? 's' : '');
        }
        if (0 !== $this->value->m) {
            $parts[] = $this->value->m.' month'.(abs($this->value->m) > 1 ? 's' : '');
        }
        if (0 !== $this->value->d) {
            $parts[] = $this->value->d.' day'.(abs($this->value->d) > 1 ? 's' : '');
        }
        if (0 !== $this->value->h) {
            $parts[] = $this->value->h.' hour'.(abs($this->value->h) > 1 ? 's' : '');
        }
        if (0 !== $this->value->i) {
            $parts[] = $this->value->i.' minute'.(abs($this->value->i) > 1 ? 's' : '');
        }
        if (0 !== $this->value->s) {
            $parts[] = $this->value->s.' second'.(abs($this->value->s) > 1 ? 's' : '');
        }

        return $sign.implode(', ', $parts);
    }

    final private function __construct(
        private \DateInterval $value,
    ) {
    }
}
