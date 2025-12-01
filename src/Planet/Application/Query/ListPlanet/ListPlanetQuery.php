<?php

declare(strict_types=1);

namespace Planet\Application\Query\ListPlanet;

use Shared\Infrastructure\Bus\Query\Query;

class ListPlanetQuery extends Query
{
    public function __construct(
        ?string $name = null,
        ?int $offset = null,
        ?int $limit = null,
    ) {
        parent::__construct([
            'name' => $name,
            'offset' => $offset,
            'limit' => $limit
        ]);
    }

    public function name(): ?string
    {
        return $this->data['name'];
    }

    public function offset(): ?int
    {
        return $this->data['offset'];
    }

    public function limit(): ?int
    {
        return $this->data['limit'];
    }
}