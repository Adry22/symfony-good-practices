<?php
declare(strict_types=1);

namespace Universe\Planet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="Universe\Planet\Repository\PlanetRepository")
 * @Table(name="planets")
 */
class Planet
{
    /**
     * @Id()
     * @Column(type="integer")
     * @GeneratedValue()
     */
    private int $id;

    /**
     * @Column(type="string", nullable=false)
     */
    private string $name;

    private function __construct() {}

    public static function create(string $name): self {
        $planet = new self();
        $planet->setName($name);

        return $planet;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}