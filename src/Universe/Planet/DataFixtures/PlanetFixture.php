<?php

namespace Universe\Planet\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Universe\Planet\Entity\Planet;

class PlanetFixture extends Fixture
{
    const PLANETS = [
        'Mercury',
        'Venus',
        'Earth',
        'Mars',
        'Jupiter',
        'Saturn',
        'Uranius',
        'Neptune',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::PLANETS as $planetName) {
            $planet = Planet::create($planetName);
            $manager->persist($planet);
        }

        $manager->flush();
    }
}
