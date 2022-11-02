<?php
declare(strict_types=1);

namespace Universe\Shared\DataClump;

class PaginationLimits
{
    private int $limit;
    private int $offset;

    public function __construct(int $offset = 0, int $limit = 0)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function offset(): int
    {
        return $this->offset;
    }
}