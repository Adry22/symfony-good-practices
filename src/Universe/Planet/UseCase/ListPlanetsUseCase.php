<?php
declare(strict_types=1);

namespace Universe\Planet\UseCase;

use Universe\Planet\Entity\Planet;
use Universe\Planet\Repository\PlanetRepository;

final class ListPlanetsUseCase
{
    private PlanetRepository $planetRepository;

    public function __construct(
        PlanetRepository $planetRepository
    ) {
        $this->planetRepository = $planetRepository;
    }

    public function handle(): array
    {
        $planets = $this->planetRepository->findAll();
        return $this->formatResponse($planets);
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