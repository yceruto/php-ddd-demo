<?php

namespace App\Shared\Domain\Model;

use App\Shared\Domain\Event\DomainEvent;

trait AggregateRoot
{
    /**
     * @var array<DomainEvent>
     */
    private array $events = [];

    public function pushDomainEvent(DomainEvent $event): void
    {
        $this->events[$event::class] = $event;
    }

    /**
     * @return array<DomainEvent>
     */
    public function pullDomainEvent(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
