<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use Doctrine\ORM\QueryBuilder;

interface Specification
{
    public function applyToQueryBuilder(QueryBuilder $queryBuilder): void;
}
