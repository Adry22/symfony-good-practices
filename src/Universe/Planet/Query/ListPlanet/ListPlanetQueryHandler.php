<?php
declare(strict_types=1);
namespace Universe\Planet\Query\ListPlanet;

use Universe\Planet\Entity\Planet;
use Universe\Planet\Repository\Criteria\ContainsPlanetName\ContainsPlanetNameSpecification;
use Universe\Planet\Repository\PlanetRepositoryInterface;
use Universe\Shared\Bus\Query\QueryHandler;
use Universe\Shared\Criteria\Criteria;
use Universe\Shared\Criteria\PaginationLimits;

final class ListPlanetQueryHandler implements QueryHandler
{
    public const DEFAULT_OFFSET = 0;
    public const DEFAULT_LIMIT = 30;

    private PlanetRepositoryInterface $planetRepository;

    public function __construct(
        PlanetRepositoryInterface $planetRepository
    ) {
        $this->planetRepository = $planetRepository;
    }

    public function handle(ListPlanetQuery $query): ListPlanetResult
    {
        $offset = $query->offset() ?? self::DEFAULT_OFFSET;
        $limit = $query->limit() ?? self::DEFAULT_LIMIT;

        $paginationLimits = new PaginationLimits($offset, $limit);

        // FIND BY CRITERIA
        $criteria = new Criteria(
            new ContainsPlanetNameSpecification($query->name(), $this->planetRepository),
            null,
            $paginationLimits
        );

        $planets = $this->planetRepository->findByCriteria($criteria);

        $criteria = new Criteria(new ContainsPlanetNameSpecification($query->name(), $this->planetRepository));
        $total = sizeof($this->planetRepository->findByCriteria($criteria));

        // FIND IN REPO
//        $planets = $this->planetRepository->findByName($query->name(), $paginationLimits);
//        $total = $this->planetRepository->countFindByName($query->name());

        $resources = array_map(
            function (Planet $planet) {
                return new ListPlanetResource($planet->name());
            },
            $planets
        );

        return new ListPlanetResult($paginationLimits, $total, $resources);
    }
}