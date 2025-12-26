<?php

declare(strict_types=1);

namespace Planet\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Planet\Domain\Entity\PlanetId\PlanetId;

#[ORM\Entity()]
#[ORM\Table(name:"planets")]
class Planet
{
    #[ORM\Id]
    #[ORM\Column(type:"planet_id")]
    private PlanetId $id;

    #[ORM\Column(type:"planet_name")]
    private PlanetName $name;

    private function __construct(PlanetId $id, PlanetName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function create(PlanetId $id, PlanetName $name): self
    {
        return new self($id, $name);
    }

    public function name(): PlanetName
    {
        return $this->name;
    }
}