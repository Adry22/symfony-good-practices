<?php

declare(strict_types=1);

namespace User\Domain\Event;

use Shared\Domain\Event\DomainEventInterface;
use DateTimeImmutable;

final class UserAddressChanged implements DomainEventInterface
{
    private DateTimeImmutable $occurredOn;

    public function __construct(
        private string $userId,
        private ?string $street,
        private ?string $number,
        private ?string $city,
        private ?string $country
    ) {
        $this->occurredOn = new DateTimeImmutable();
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function street(): ?string
    {
        return $this->street;
    }

    public function number(): ?string
    {
        return $this->number;
    }

    public function city(): ?string
    {
        return $this->city;
    }

    public function country(): ?string
    {
        return $this->country;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public static function name(): string
    {
        return 'user.address_changed';
    }
}