<?php
declare(strict_types=1);

namespace Universe\Planet\Repository;

use Doctrine\ORM\QueryBuilder;
use Universe\Planet\Entity\Planet;
use Universe\Shared\Repository\BaseRepository;

class PlanetRepository extends BaseRepository
{
    private const ROOT_ALIAS = 'planets';

    public function findByName(?string $name = null): array
    {
        $queryBuilder = $this->createQueryBuilder(self::ROOT_ALIAS);

        if ($name) {
            $queryBuilder = $this->applyName($queryBuilder, $name);
        }

        return $queryBuilder->getQuery()->getResult();
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