<?php

declare(strict_types=1);

namespace Planet\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Planet\Domain\Entity\PlanetId\PlanetId;

#[ORM\Entity()]
#[ORM\Table(name:"planets")]
final class Planet
{
    #[ORM\Id]
    #[ORM\Column(type:"planet_id")]
    private PlanetId $id;

    #[ORM\Column(type:"planet_name")]
    private PlanetName $name;

    private function __construct() {}

    public static function create(PlanetName $name): self {
        $planet = new self();
        $planet->setName($name);

        return $planet;
    }

    public function name(): PlanetName
    {
        return $this->name;
    }

    public function setName(PlanetName $name): void
    {
        $this->name = $name;
    }
}