<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

final class Criteria
{
    private Specification $specification;
    private ?Order $order;
    private ?PaginationLimits $paginationLimits;

    public function __construct(Specification $specification, ?Order $order = null, ?PaginationLimits $paginationLimits = null)
    {
        $this->specification = $specification;
        $this->order = $order;
        $this->paginationLimits = $paginationLimits;
    }

    public function specification(): Specification
    {
        return $this->specification;
    }

    public function order(): ?Order
    {
        return $this->order;
    }

    public function paginationLimits(): ?PaginationLimits
    {
        return $this->paginationLimits;
    }
}
