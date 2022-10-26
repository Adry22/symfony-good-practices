<?php

namespace Universe\User\Command\RegisterUser;

use Universe\Shared\Bus\Command\Command;

class RegisterUserCommand extends Command
{
    public function __construct(string $email, string $password)
    {
        parent::__construct([
            'email' => $email,
            'password' => $password
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
}