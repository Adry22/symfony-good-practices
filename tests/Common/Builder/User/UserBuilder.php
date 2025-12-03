<?php

declare(strict_types=1);

namespace Tests\Common\Builder\User;

use Exception;
use User\Domain\Entity\User\User;
use User\Domain\Entity\User\UserId\UserId;

class UserBuilder
{
    private UserId $id;
    private ?string $email;
    private ?string $password;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->id = UserId::random();
        $this->email = null;
        $this->password = null;

        return $this;
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

        return $user;
    }

    public function withId(UserId $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function withEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function withPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}