<?php

declare(strict_types=1);

namespace Shared\Domain\Repository;

interface BaseRepositoryInterface
{
    public function save($object): void;

    public function flush(): void;

    public function remove($object): void;
}