<?php
declare(strict_types=1);

namespace Universe\Planet\Repository\Doctrine;

use Doctrine\ORM\QueryBuilder;
use Universe\Planet\Entity\Planet;
use Universe\Planet\Repository\PlanetRepositoryInterface;
use Universe\Shared\Criteria\Criteria;
use Universe\Shared\Criteria\PaginationLimits;
use Universe\Shared\Repository\BaseRepository;

class DoctrinePlanetRepository extends BaseRepository implements PlanetRepositoryInterface
{
    private const ROOT_ALIAS = 'planets';

    public function findByCriteria(Criteria $criteria) {
        return $criteria->specification()->satisfyingElementsFrom($this);
    }

    public function findAll(): array
    {
        return $this->findBy([]);
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