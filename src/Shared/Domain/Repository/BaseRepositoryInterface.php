<?php

declare(strict_types=1);

namespace Shared\Domain\Repository;

interface BaseRepositoryInterface
{
    public function save($object);

    public function flush();

    public function remove($object): void;
}