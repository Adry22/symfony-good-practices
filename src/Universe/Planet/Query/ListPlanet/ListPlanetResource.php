<?php
declare(strict_types=1);
namespace Universe\Planet\Query\ListPlanet;

class ListPlanetResource
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}