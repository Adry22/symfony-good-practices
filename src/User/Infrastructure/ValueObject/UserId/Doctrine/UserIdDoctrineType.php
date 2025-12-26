<?php

declare(strict_types=1);

namespace User\Infrastructure\ValueObject\UserId\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Entity\User\UserId\UserIdInvalidArgumentException;

final class UserIdDoctrineType extends StringType
{
    public const NAME = 'user_id';

    /**
     * @throws UserIdInvalidArgumentException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserId
    {
        if (null === $value || $value instanceof UserId) {
            return $value;
        }

        return UserId::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof UserId) {
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
