<?php

declare(strict_types=1);

namespace Shared\Infrastructure\ValueObject\Email\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Shared\Domain\ValueObject\Email;
use Shared\Domain\ValueObject\EmailInvalidArgumentException;

class EmailDoctrineType extends Type
{
    private const NAME = 'email';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL([
            'length' => 254,
        ]);
    }

    /**
     * @throws EmailInvalidArgumentException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        if (null === $value || $value instanceof Email) {
            return $value;
        }

        return new Email($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof Email) {
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