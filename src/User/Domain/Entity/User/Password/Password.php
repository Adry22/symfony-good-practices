<?php

declare(strict_types=1);

namespace User\Domain\Entity\User\Password;

final class Password
{
    private const MIN_LENGTH = 8;
    private const MAX_LENGTH = 25;

    public function __construct(private string $password)
    {
        $this->checkPasswordIsNotEmpty($password);
        $this->checkPasswordIsNotTooShort($password);
        $this->checkPasswordIsNotTooLong($password);
    }

    private function checkPasswordIsNotEmpty(string $password): void
    {
        if (empty($password)) {
            throw new PasswordInvalidArgumentException('Password must not be empty.');
        }
    }

    private function checkPasswordIsNotTooShort(string $password): void
    {
        if (strlen($password) < self::MIN_LENGTH) {
            throw new PasswordInvalidArgumentException(
                sprintf('Password must be at least %d characters long', self::MIN_LENGTH)
            );
        }
    }

    private function checkPasswordIsNotTooLong(string $password): void
    {
        if (strlen($password) > self::MAX_LENGTH) {
            throw new PasswordInvalidArgumentException(
                sprintf('Password cannot exceed %d characters', self::MAX_LENGTH)
            );
        }
    }

    public function toString(): string
    {
        return $this->password;
    }
}
