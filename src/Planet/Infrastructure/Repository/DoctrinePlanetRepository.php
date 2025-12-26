<?php

declare(strict_types=1);

namespace Planet\Infrastructure\Repository;

use Doctrine\ORM\QueryBuilder;
use Planet\Domain\Entity\Planet;
use Planet\Domain\Repository\PlanetRepositoryInterface;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\PaginationLimits;
use Shared\Infrastructure\Repository\BaseRepository;

class DoctrinePlanetRepository extends BaseRepository implements PlanetRepositoryInterface
{
    private const ROOT_ALIAS = 'planets';

    public function findByCriteria(Criteria $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder(self::ROOT_ALIAS);

        $criteria->specification()->applyToQueryBuilder($queryBuilder);

        if (null !== $criteria->order()) {
            $queryBuilder->orderBy(self::ROOT_ALIAS . '.' . $criteria->order()->field(), $criteria->order()->direction());
        }

        if (null !== $criteria->paginationLimits()) {
            $queryBuilder->setFirstResult($criteria->paginationLimits()->offset())
                ->setMaxResults($criteria->paginationLimits()->limit());
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function findAll(): array
    {
        return $this->repository->findBy([]);
    }

    public function findByName(
        ?string $name = null,
        ?PaginationLimits $paginationLimits = null
    ): array {
        $queryBuilder = $this->createQueryBuilder(self::ROOT_ALIAS);

        if ($name) {
            $queryBuilder = $this->applyName($queryBuilder, $name);
        }

        if ($paginationLimits) {
            $queryBuilder->setFirstResult($paginationLimits->offset());
            $queryBuilder->setMaxResults($paginationLimits->limit());
        }


        return $queryBuilder->getQuery()->getResult();
    }

    public function countFindByName(?string $name = null): int
    {
        $queryBuilder = $this->createQueryBuilder(self::ROOT_ALIAS);
        $queryBuilder->select('COUNT(' . self::ROOT_ALIAS . '.id)');

        if ($name) {
            $queryBuilder = $this->applyName($queryBuilder, $name);
        }

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }

    private function applyName(QueryBuilder $queryBuilder, string $name): QueryBuilder
    {
        return $queryBuilder->andWhere(self::ROOT_ALIAS . '.name LIKE :name')
            ->setParameter('name', '%' . $name . '%');
    }

    public function getEntityClassName(): string
    {
        return Planet::class;
    }
}