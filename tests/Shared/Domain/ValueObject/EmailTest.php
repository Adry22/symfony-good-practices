<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /** @test */
    public function should_create_email_when_is_valid(): void
    {
        $email = new Email('test@email.com');

        $this->assertSame('test@email.com', $email->toString());
    }

    /**
     * @test
     * @dataProvider invalidEmailsProvider
     */
    public function should_throw_exception_when_email_is_not_valid(string $email): void
    {
        $this->expectException(EmailInvalidArgumentException::class);

        new Email($email);
    }

    /**
     * @return array<string, list<string>>
     */
    public static function invalidEmailsProvider(): array
    {
        return [
            'Empty' => [''],
            'Whitespace' => [' '],
            'Invalid' => ['1234'],
            'Too long' => ['dummydummydummydummydummmmydummydummydummydummydummmmydummydummydummydummydummydummydummydummydummydummydummmmydummydummydummydummydummmmydummydummydummydummydummydummydummydummydummydummydummmmydummydummydummydummydummmmydummydummydummydummydummy@dummy.com']
        ];
    }
}
