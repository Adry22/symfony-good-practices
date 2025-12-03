<?php

declare(strict_types=1);

namespace Shared\Domain\Aggregate;

use Shared\Domain\Event\DomainEventInterface;

abstract class AggregateRoot
{
    /** @var DomainEventInterface[] */
    private array $recordedEvents = [];

    final protected function record(DomainEventInterface $event): void
    {
        $this->recordedEvents[] = $event;
    }

    /**
     * @return DomainEventInterface[]
     */
    final public function pullEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];

        return $events;
    }
}