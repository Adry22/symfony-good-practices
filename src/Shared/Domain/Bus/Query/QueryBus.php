<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Query;

use Shared\Infrastructure\Bus\Query\Query;

interface QueryBus
{
    public function handle(Query $query): Result;
}