<?php

declare(strict_types=1);

namespace Tests\Common\Builder\User;

use Exception;
use ReflectionClass;
use Shared\Domain\ValueObject\Email;
use User\Domain\Entity\User\User;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Entity\User\UserProfile;

final class UserBuilder
{
    private UserId $id;
    private ?Email $email = null;
    private ?string $password = null;
    private UserProfile $profile;

    public function __construct()
    {
        $this->id = UserId::random();
        $this->profile = (new UserProfileBuilder())->build();
    }

    /**
     * @throws Exception
     */
    public function build(): User
    {
        if (null === $this->email) {
            throw new Exception('Email is required');
        }

        if (null === $this->password) {
            throw new Exception('Password is required');
        }

        $user = User::create(UserId::random(), $this->email);
        $user->setPassword($this->password);

        if (null !== $this->profile) {
            $reflection = new ReflectionClass($user);
            $property = $reflection->getProperty('profile');
            $property->setValue($user, $this->profile);
        }

        $user->pullEvents();

        return $user;
    }

    public function withId(UserId $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function withEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function withPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function withProfile(UserProfile $profile): self
    {
        $this->profile = $profile;
        return $this;
    }
}