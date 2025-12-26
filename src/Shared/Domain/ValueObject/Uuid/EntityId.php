<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Uuid;

interface EntityId
{
    public static function random(): static;
    public static function fromString(string $uuid): static;
    public function toString(): string;
    public function __toString(): string;
}
