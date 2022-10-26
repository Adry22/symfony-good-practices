<?php
declare(strict_types=1);
namespace Universe\Shared\Bus\Query;

interface QueryBus
{
    public function handle(Query $query): Result;
}