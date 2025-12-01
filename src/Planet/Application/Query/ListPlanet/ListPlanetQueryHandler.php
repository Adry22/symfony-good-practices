<?php

declare(strict_types=1);

namespace Planet\Application\Query\ListPlanet;

use Planet\Domain\Entity\Planet;
use Planet\Domain\Repository\PlanetRepositoryInterface;
use Planet\Infrastructure\Repository\Criteria\ContainsPlanetName\ContainsPlanetNameSpecification;
use Shared\Domain\Bus\Query\QueryHandler;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\PaginationLimits;

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