<?php
declare(strict_types=1);

namespace Universe\Shared\Criteria;

final class Order
{
    private const DEFAULT_ORDER_TYPE = 'ASC';

    private string $orderBy;
    private string $orderType;

    public function __construct(string $orderBy, string $orderType)
    {
        $this->orderBy = $orderBy;
        $this->orderType = $orderType ?: self::DEFAULT_ORDER_TYPE;
    }
}
