<?php

declare(strict_types=1);

namespace Planet\Domain\Entity;

final class PlanetName
{
    public function __construct(private string $value) {}

    public function toString(): string
    {
        return $this->value;
    }
}