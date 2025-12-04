<?php

declare(strict_types=1);

namespace Planet\Infrastructure\Type\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Planet\Domain\Entity\PlanetName;

class PlanetNameDoctrineType extends StringType
{
    const PLANET_NAME = 'planet_name';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?PlanetName
    {
        return null !== $value ? new PlanetName($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        return $value->toString();
    }

    public function getName(): string
    {
        return self::PLANET_NAME;
    }
}