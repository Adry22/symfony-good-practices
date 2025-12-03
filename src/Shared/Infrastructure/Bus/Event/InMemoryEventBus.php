<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

use Shared\Domain\Bus\Event\EventBus;
use Shared\Domain\Event\DomainEventInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class InMemoryEventBus implements EventBus
{
    public function __construct(private EventDispatcherInterface $eventDispatcher)
    {
    }

    public function publish(DomainEventInterface ...$events): void
    {
        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event, $event::name());
        }
    }
}