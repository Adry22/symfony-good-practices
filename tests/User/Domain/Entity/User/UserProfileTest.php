<?php

declare(strict_types=1);

namespace User\Domain\Entity\User;

use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\Email;
use User\Domain\Entity\User\UserId\UserId;

class UserProfileTest extends TestCase
{
    /** @test */
    public function should_update_profile_when_everything_is_valid(): void
    {
        $user = User::create(UserId::random(), new Email('test@example.com'));

        $user->updateProfile(
            'Main St',
            '123',
            'Madrid',
            'Spain',
            'John Doe'
        );

        $this->assertSame('John Doe', $user->profile()->name());
        $this->assertSame('Main St 123, Madrid, Spain', $user->profile()->address()->toString());
    }
}
