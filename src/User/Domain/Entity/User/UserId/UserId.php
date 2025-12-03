<?php

declare(strict_types=1);

namespace User\Domain\Entity\User\UserId;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserId
{
    private UuidInterface $uuid;

    final private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function random(): static
    {
        return new static(Uuid::uuid4());
    }

    /**
     * @throws UserIdInvalidArgumentException
     */
    public static function fromString(string $uuid): static
    {
        self::checkIsValid($uuid);

        return new static(Uuid::fromString($uuid));
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @throws UserIdInvalidArgumentException
     */
    private static function checkIsValid(string $uuid): void
    {
        if (false === Uuid::isValid($uuid) || Uuid::fromString($uuid)->getVersion() !== 4) {
            throw new UserIdInvalidArgumentException();
        }
    }
}