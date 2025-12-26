<?php

declare(strict_types=1);

namespace User\Domain\Entity\User\Password;

final class Password
{
    private const MIN_LENGTH = 8;
    private const MAX_LENGTH = 25;

    private function __construct(
        private readonly string $password,
        private readonly bool $isPlainText = true
    ) {
        if (true === $this->isPlainText) {
            $this->checkPasswordIsNotEmpty($this->password);
            $this->checkPasswordIsNotTooShort($this->password);
            $this->checkPasswordIsNotTooLong($this->password);
        }
    }

    public static function fromString(string $password): Password
    {
        return new self($password);
    }

    public static function fromHash(string $password): Password
    {
        return new self($password, false);
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
