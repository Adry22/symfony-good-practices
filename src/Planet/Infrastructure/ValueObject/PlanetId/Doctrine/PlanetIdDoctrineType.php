<?php

declare(strict_types=1);

namespace Planet\Infrastructure\ValueObject\PlanetId\Doctrine;

use Doctrine\DBAL\Types\StringType;
use Planet\Domain\Entity\PlanetId\PlanetId;
use Planet\Domain\Entity\PlanetId\PlanetIdInvalidArgumentException;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class PlanetIdDoctrineType extends StringType
{
    public const NAME = 'planet_id';

    /**
     * @throws PlanetIdInvalidArgumentException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?PlanetId
    {
        if (null === $value || $value instanceof PlanetId) {
            return $value;
        }

        return PlanetId::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof PlanetId) {
            return $value->toString();
        }

        return $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}