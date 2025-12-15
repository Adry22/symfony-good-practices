<?php

declare(strict_types=1);

namespace Planet\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Planet\Domain\Entity\Planet;
use Planet\Domain\Entity\PlanetName;

class PlanetFixture extends Fixture
{
    const PLANETS = [
        'Mercury',
        'Venus',
        'Earth',
        'Mars',
        'Jupiter',
        'Saturn',
        'Uranus',
        'Neptune',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::PLANETS as $planetName) {
            $planet = Planet::create(new PlanetName($planetName));
            $manager->persist($planet);
        }

        $manager->flush();
    }
}
