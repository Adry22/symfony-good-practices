<?php

declare(strict_types=1);

namespace Tests\Common\Builder\Planet;

use Exception;
use Planet\Domain\Entity\Planet;

class PlanetBuilder
{
    private ?string $name;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->name = null;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function build(): Planet
    {
        if (null === $this->name) {
            throw new Exception('Name is required');
        }

        return Planet::create($this->name);

    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
