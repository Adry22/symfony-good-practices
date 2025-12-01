<?php

namespace User\Application\Command\RegisterUser;

use Universe\Shared\Bus\Command\Command;

class RegisterUserCommand extends Command
{
    public function __construct(
        string $email,
        string $password,
        ?string $street = null,
        ?string $number = null,
        ?string $city = null,
        ?string $country = null
    ) {
        parent::__construct([
            'email' => $email,
            'password' => $password,
            'street' => $street,
            'number' => $number,
            'city' => $city,
            'country' => $country,
        ]);
    }

    public function email(): string
    {
        return $this->data['email'];
    }

    public function password(): string
    {
        return $this->data['password'];
    }

    public function street(): ?string
    {
        return $this->data['street'];
    }

    public function number(): ?string
    {
        return $this->data['number'];
    }

    public function city(): ?string
    {
        return $this->data['city'];
    }

    public function country(): ?string
    {
        return $this->data['country'];
    }
}