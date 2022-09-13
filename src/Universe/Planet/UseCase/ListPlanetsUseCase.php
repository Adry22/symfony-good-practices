<?php
declare(strict_types=1);

namespace Universe\Planet\UseCase;

use Universe\Planet\Entity\Planet;
use Universe\Planet\Exception\PlanetsNotFoundException;
use Universe\Planet\Repository\PlanetRepository;

final class ListPlanetsUseCase
{
    private PlanetRepository $planetRepository;

    public function __construct(
        PlanetRepository $planetRepository
    ) {
        $this->planetRepository = $planetRepository;
    }

    /**
     * @throws PlanetsNotFoundException
     */
    public function handle(?string $name = null): array
    {
        $planets = $this->planetRepository->findByName($name);
        $this->checkAtLeastOnePlanetFound($planets);

        return $this->formatResponse($planets);
    }

    /**
     * @throws PlanetsNotFoundException
     */
    private function checkAtLeastOnePlanetFound(array $planets): void
    {
        if (0 === sizeof($planets)) {
            throw new PlanetsNotFoundException();
        }
    }

    private function formatResponse(array $planets): array
    {
        $planetsFormatted = [];

        /** @var Planet $planet */
        foreach ($planets as $planet) {
            $planetsFormatted[] = $planet->name();
        }

        return $planetsFormatted;
    }
}