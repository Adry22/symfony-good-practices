<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Middleware;

use League\Tactician\Middleware;
use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\Bus\Event\EventBus;

final class DomainEventPublisherMiddleware implements Middleware
{
    public function __construct(private EventBus $eventBus)
    {
    }

    public function execute($command, callable $next)
    {
        $returnValue = $next($command);

        if ($returnValue instanceof AggregateRoot) {
            $events = $returnValue->pullEvents();

            if (!empty($events)) {
                $this->eventBus->publish(...$events);
            }
        }

        return $returnValue;
    }
}