<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Uuid;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use InvalidArgumentException;

abstract class UuidValueObject implements EntityId
{
    public const UUID_VERSION = 4;

    private UuidInterface $uuid;

    final private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function random(): static
    {
        return new static(Uuid::uuid4());
    }

    public static function fromString(string $uuid): static
    {
        static::checkIsValid($uuid);

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
     * @throws InvalidArgumentException
     */
    private static function checkIsValid(string $uuid): void
    {
        if (false === Uuid::isValid($uuid) || Uuid::fromString($uuid)->getVersion() !== self::UUID_VERSION) {
            throw static::createInvalidArgumentException();
        }
    }

    abstract protected static function createInvalidArgumentException(): InvalidArgumentException;
}
