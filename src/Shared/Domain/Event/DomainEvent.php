<?php

namespace App\Shared\Domain\Event;

use App\Shared\Domain\Model\Uuid;

abstract readonly class DomainEvent
{
    public string $aggregateId;
    public string $eventId;
    public string $occurredOn;

    public static function new(Uuid $aggregateId): static
    {
        return new static($aggregateId);
    }

    final private function __construct(Uuid $aggregateId)
    {
        $this->aggregateId = $aggregateId->toString();
        $this->eventId = Uuid::raw();
        $this->occurredOn = (new \DateTimeImmutable())->format('c');
    }
}
