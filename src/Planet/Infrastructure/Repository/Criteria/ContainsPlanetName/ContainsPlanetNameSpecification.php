<?php
declare(strict_types=1);

namespace Planet\Infrastructure\Repository\Criteria\ContainsPlanetName;

use Planet\Domain\Entity\Planet;
use Planet\Domain\Repository\PlanetRepositoryInterface;
use Universe\Shared\Criteria\Specification;

class ContainsPlanetNameSpecification implements Specification
{
    private ?string $name;
    private PlanetRepositoryInterface $planetRepository;

    public function __construct(?string $name, $planetRepository)
    {
        $this->name = $name;
        $this->planetRepository = $planetRepository;
    }

    public function isSatisfiedBy(Planet $planet): bool
    {
        if (str_contains($planet->name(), $this->name)) {
            return true;
        }

        return false;
    }

    public function satisfyingElementsFrom($repository): array
    {
        $planets = $this->planetRepository->findAll();

        if (null === $this->name) {
            return $planets;
        }

        return array_values(array_filter($planets, function(Planet $planet) {
            return $this->isSatisfiedBy($planet);
        }));
    }
}
