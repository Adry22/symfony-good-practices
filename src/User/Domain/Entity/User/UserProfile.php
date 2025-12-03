<?php

declare(strict_types=1);

namespace User\Domain\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use User\Domain\Entity\User\Address\Address;

/**
 * @ORM\Embeddable()
 */
class UserProfile
{
    /**
     * @Column(type="string", nullable=true)
     */
    private ?string $name;

    /**
     * @ORM\Embedded(class="User\Domain\Entity\User\Address\Address")
     */
    private ?Address $address;

    private function __construct(
        ?Address $address,
        ?string $name
    ) {
        $this->address = $address;
        $this->name = $name;
    }

    public static function empty(): self
    {
        return new self(null, null);
    }

    public function update(?Address $address, ?string $name): void
    {
        $this->address = $address;
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function address(): ?Address
    {
        return $this->address;
    }
}