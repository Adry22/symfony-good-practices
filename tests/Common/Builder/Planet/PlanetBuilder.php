<?php

declare(strict_types=1);

namespace Tests\Common\Builder\Planet;

use Exception;
use Planet\Domain\Entity\Planet;
use Planet\Domain\Entity\PlanetName;

final class PlanetBuilder
{
    private ?string $name = null;

    /**
     * @throws Exception
     */
    public function build(): Planet
    {
        if (null === $this->name) {
            throw new Exception('Name is required');
        }

        return Planet::create(new PlanetName($this->name));

    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
