<?php

declare(strict_types=1);

namespace User\Domain\Event;

use Shared\Domain\Event\DomainEventInterface;
use DateTimeImmutable;

final class UserRegistered implements DomainEventInterface
{
    private DateTimeImmutable $occurredOn;

    public function __construct(
        private string $userId,
        private string $email,
    ) {
        $this->occurredOn = new DateTimeImmutable();
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public static function name(): string
    {
        return 'user.registered';
    }
}