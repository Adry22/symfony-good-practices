<?php

declare(strict_types=1);

namespace User\Domain\Entity\User;

use Monolog\Test\TestCase;
use User\Domain\Entity\User\UserId\UserId;

class UserProfileTest extends TestCase
{
    /** @test */
    public function should_update_profile_when_everything_is_valid(): void
    {
        $user = User::create(UserId::random(), 'test@example.com');

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
