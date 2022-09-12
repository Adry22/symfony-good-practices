<?php
declare(strict_types=1);

namespace Universe\Planet\Repository;

use Universe\Planet\Entity\Planet;
use Universe\Shared\Repository\BaseRepository;

class PlanetRepository extends BaseRepository
{
    public function getEntityClassName(): string
    {
        return Planet::class;
    }
}