<?php

declare(strict_types=1);

namespace User\Domain\Entity\User\Password;

use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    /**
     * @test
     */
    public function should_create_password_when_is_correct(): void
    {
        $password = Password::fromString('password');

        $this->assertSame('password', $password->toString());
    }

    /**
     * @test
     * @dataProvider invalidPasswords
     */
    public function should_throw_exception_when_password_is_invalid(string $password): void
    {
        $this->expectException(PasswordInvalidArgumentException::class);

        new Password($password);
    }

    public function invalidPasswords(): array
    {
        return [
            ['Empty' => ''],
            ['Too short' => 'aa'],
            ['Too long' => 'passwordTooLongpasswordTooLongpasswordTooLongpasswordTooLong'],
        ];
    }
}
