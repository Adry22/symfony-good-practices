<?php
declare(strict_types=1);
namespace Universe\Planet\Query;

use Universe\Shared\Bus\Query\Result;

class ListPlanetResult implements Result
{
    /** @var ListPlanetResource[]  */
    private array $results;

    public function __construct(array $results)
    {
        $this->results = $results;
    }

    /**
     * @return ListPlanetResource[]
     */
    public function results(): array
    {
        return $this->results;
    }
}