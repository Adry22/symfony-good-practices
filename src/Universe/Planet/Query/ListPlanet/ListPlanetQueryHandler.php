<?php
declare(strict_types=1);
namespace Universe\Planet\Query\ListPlanet;

use Universe\Planet\Entity\Planet;
use Universe\Planet\Repository\PlanetRepository;
use Universe\Shared\Bus\Query\QueryHandler;
use Universe\Shared\DataClump\PaginationLimits;

final class ListPlanetQueryHandler implements QueryHandler
{
    public const DEFAULT_OFFSET = 0;
    public const DEFAULT_LIMIT = 30;

    private PlanetRepository $planetRepository;

    public function __construct(
        PlanetRepository $planetRepository
    ) {
        $this->planetRepository = $planetRepository;
    }

    public function handle(ListPlanetQuery $query): ListPlanetResult
    {
        $offset = $query->offset() ?? self::DEFAULT_OFFSET;
        $limit = $query->limit() ?? self::DEFAULT_LIMIT;

        $paginationLimits = new PaginationLimits($offset, $limit);

        $planets = $this->planetRepository->findByName($query->name(), $paginationLimits);
        $total = $this->planetRepository->countFindByName($query->name());

        $resources = array_map(
            function (Planet $planet) {
                return new ListPlanetResource($planet->name());
            },
            $planets
        );

        return new ListPlanetResult($paginationLimits, $total, $resources);
    }
}