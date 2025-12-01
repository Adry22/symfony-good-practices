<?php

declare(strict_types=1);

namespace Planet\Domain\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity()
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