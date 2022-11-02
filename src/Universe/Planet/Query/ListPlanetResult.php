<?php
declare(strict_types=1);
namespace Universe\Planet\Query;

use Universe\Shared\Bus\Query\Result;
use Universe\Shared\DataClump\PaginationLimits;

class ListPlanetResult implements Result
{
    /** @var ListPlanetResource[]  */
    private array $results;
    private int $offset;
    private int $limit;
    private int $total;

    public function __construct(PaginationLimits $paginationLimits, int $total, array $results)
    {
        $this->offset = $paginationLimits->offset();
        $this->limit = $paginationLimits->limit();
        $this->total = $total;
        $this->results = $results;
    }

    public function offset(): int
    {
        return $this->offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function total(): int
    {
        return $this->total;
    }

    /**
     * @return ListPlanetResource[]
     */
    public function results(): array
    {
        return $this->results;
    }
}