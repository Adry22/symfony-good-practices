<?php

declare(strict_types=1);

namespace Planet\Infrastructure\Repository\Criteria\ContainsPlanetName;

use Doctrine\ORM\QueryBuilder;
use Shared\Domain\Criteria\Specification;

readonly class ContainsPlanetNameSpecification implements Specification
{
    public function __construct(private ?string $name = null)
    {
    }

    public function applyToQueryBuilder(QueryBuilder $queryBuilder): void
    {
        if (null === $this->name) {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];

        $queryBuilder
            ->andWhere($alias . '.name LIKE :name')
            ->setParameter('name', '%' . $this->name . '%');
    }
}
