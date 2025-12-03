<?php

declare(strict_types=1);

namespace User\Application\Command\RegisterUser;

use Shared\Infrastructure\Bus\Command\Command;

class RegisterUserCommand extends Command
{
    public function __construct(
        string $uuid,
        string $email,
        string $password
    ) {
        parent::__construct([
            'uuid' => $uuid,
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function uuid(): string
    {
        return $this->data['uuid'];
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