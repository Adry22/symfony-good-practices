<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

final class Order
{
    private const DEFAULT_ORDER_TYPE = 'ASC';

    public function __construct(
        private string $field,
        private string $direction = self::DEFAULT_ORDER_TYPE
    ) {
    }

    public function field(): string
    {
        return $this->field;
    }

    public function direction(): string
    {
        return $this->direction;
    }
}
