<?php
declare(strict_types=1);

namespace Universe\Planet\Repository;

use Universe\Shared\DataClump\PaginationLimits;

interface PlanetRepositoryInterface
{
    public function findByName(?string $name = null, ?PaginationLimits $paginationLimits = null): array;

    public function countFindByName(?string $name = null): int;

    public function getEntityClassName(): string;
}