<?php

namespace Universe\Shared\Bus\Query;

use League\Tactician\CommandBus as TacticianBus;

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