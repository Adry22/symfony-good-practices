<?php

declare(strict_types=1);

namespace User\Infrastructure\ValueObject\Password\Doctrine;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use User\Domain\Entity\User\Password\Password;

final class PasswordDoctrineType extends StringType
{
    private const NAME = 'password';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Password
    {
        if (null === $value || '' === $value) {
            return null;
        }

        return Password::fromHash($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof Password) {
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
