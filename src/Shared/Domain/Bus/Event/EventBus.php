<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

use Shared\Domain\Event\DomainEventInterface;

interface EventBus
{
    public function publish(DomainEventInterface ...$events): void;
}