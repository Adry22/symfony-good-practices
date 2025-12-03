<?php

declare(strict_types=1);

namespace Shared\Domain\Event;

interface DomainEventInterface
{
    public function occurredOn(): \DateTimeImmutable;
    public static function name(): string;
}
