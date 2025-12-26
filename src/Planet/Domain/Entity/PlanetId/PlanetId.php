<?php

declare(strict_types=1);

namespace Planet\Domain\Entity\PlanetId;

use Shared\Domain\ValueObject\Uuid\UuidValueObject;
use InvalidArgumentException;

class PlanetId extends UuidValueObject
{
    protected static function createInvalidArgumentException(): InvalidArgumentException
    {
        return new PlanetIdInvalidArgumentException();
    }
}
