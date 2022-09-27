<?php
declare(strict_types=1);

namespace Tests\Common\Builder\Planet;

use Doctrine\ORM\EntityManagerInterface;
use Universe\Planet\Entity\Planet;
use Exception;

class PlanetBuilder
{
    private EntityManagerInterface $entityManager;
    private ?string $name;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function reset(): self
    {
        $this->name = null;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function build()
    {
        if (null === $this->name) {
            throw new Exception('Name is required');
        }

        $planet = Planet::create($this->name);

        $this->entityManager->persist($planet);
        $this->entityManager->flush();
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
