<?php

declare(strict_types=1);

namespace User\Application\Command\UpdateProfileUser;

use Shared\Infrastructure\Bus\Command\Command;

class UpdateProfileUserCommand extends Command
{
    public function __construct(
        string $userId,
        ?string $street = null,
        ?string $number = null,
        ?string $city = null,
        ?string $country = null,
        ?string $name = null
    ) {
        parent::__construct([
            'userId' => $userId,
            'name' => $name,
            'street' => $street,
            'number' => $number,
            'city' => $city,
            'country' => $country,
        ]);
    }

    public function userId(): string
    {
        return $this->data['userId'];
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

    public function name(): ?string
    {
        return $this->data['name'];
    }
}
