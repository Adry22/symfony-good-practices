<?php
declare(strict_types=1);
namespace Universe\Planet\Query;

use Universe\Shared\Bus\Query\Query;

class ListPlanetQuery extends Query
{
    public function __construct(?string $name = null)
    {
        parent::__construct([
            'name' => $name
        ]);
    }

    public function name(): ?string
    {
        return $this->data['name'];
    }
}