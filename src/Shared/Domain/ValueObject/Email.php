<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

final class Email
{
    public const MAX_LENGTH = 254;

    private string $email;

    /**
     * @throws EmailInvalidArgumentException
     */
    public function __construct(string $email)
    {
        $this->checkEmailIsNotEmpty($email);
        $this->checkEmailIsValid($email);
        $this->checkEmailIsNotTooLong($email);

        $this->email = strtolower(trim($email));
    }

    /**
     * @throws EmailInvalidArgumentException
     */
    private function checkEmailIsNotEmpty(string $email): void
    {
        if ('' === $email) {
            throw new EmailInvalidArgumentException();
        }
    }

    /**
     * @throws EmailInvalidArgumentException
     */
    private function checkEmailIsValid(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailInvalidArgumentException();
        }
    }

    /**
     * @throws EmailInvalidArgumentException
     */
    private function checkEmailIsNotTooLong(string $email): void
    {
        if (strlen($email) > self::MAX_LENGTH) {
            throw new EmailInvalidArgumentException();
        }
    }

    public function toString(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}