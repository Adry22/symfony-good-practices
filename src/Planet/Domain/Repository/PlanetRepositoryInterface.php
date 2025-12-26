<?php
declare(strict_types=1);

namespace Planet\Domain\Repository;

use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\PaginationLimits;

interface PlanetRepositoryInterface
{
    public function findByCriteria(Criteria $criteria): array;

    public function findByName(?string $name = null, ?PaginationLimits $paginationLimits = null): array;

    public function countFindByName(?string $name = null): int;

    public function getEntityClassName(): string;

    public function findAll(): array;

    public function save($object): void;

    public function flush(): void;
}