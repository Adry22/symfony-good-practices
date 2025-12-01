<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Query;

use League\Tactician\CommandBus as TacticianBus;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Domain\Bus\Query\Result;

class TacticianQueryBus implements QueryBus
{
    private TacticianBus $queryBus;

    public function __construct(TacticianBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function handle(Query $query): Result
    {
        return $this->queryBus->handle($query);
    }
}