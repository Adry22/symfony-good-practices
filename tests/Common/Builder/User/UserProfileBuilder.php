<?php

declare(strict_types=1);

namespace Tests\Common\Builder\User;

use User\Domain\Entity\User\Address\Address;
use User\Domain\Entity\User\UserProfile;

final class UserProfileBuilder
{
    private ?Address $address;
    private ?string $name = null;

    public function __construct()
    {
        $this->address = new Address();
    }

    public function withAddress(Address $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function withName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function build(): UserProfile
    {
        return new UserProfile(
            $this->address,
            $this->name
        );
    }
}
