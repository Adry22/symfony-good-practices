<?php

declare(strict_types=1);

namespace User\Domain\Event;

use DateTimeImmutable;
use Shared\Domain\Event\DomainEventInterface;

final class UserNameChanged implements DomainEventInterface
{
    private DateTimeImmutable $occurredOn;

    public function __construct(
        private string $userId,
        private string $newName,
        private ?string $oldName
    ) {
        $this->occurredOn = new DateTimeImmutable();
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function newName(): string
    {
        return $this->newName;
    }

    public function oldName(): string
    {
        return $this->oldName;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public static function name(): string
    {
        return 'user.name_changed';
    }
}