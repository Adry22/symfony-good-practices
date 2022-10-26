<?php
declare(strict_types=1);
namespace Universe\Planet\Query;

use Universe\Planet\Entity\Planet;
use Universe\Planet\Exception\PlanetsNotFoundException;
use Universe\Planet\Repository\PlanetRepository;
use Universe\Shared\Bus\Query\QueryHandler;

final class ListPlanetQueryHandler implements QueryHandler
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
    public function handle(ListPlanetQuery $query): ListPlanetResult
    {
        $planets = $this->planetRepository->findByName($query->name());
        $this->checkAtLeastOnePlanetFound($planets);

        $resources = array_map(
            function (Planet $planet) {
                return new ListPlanetResource($planet->name());
            },
            $planets
        );

        return new ListPlanetResult($resources);
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
}