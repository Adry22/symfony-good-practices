<?php

declare(strict_types=1);

namespace Planet\Application\Query\ListPlanet;

use Monolog\Test\TestCase;
use Planet\Domain\Repository\PlanetRepositoryInterface;
use Tests\Common\Builder\BuilderFactory;

class ListPlanetQueryHandlerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->builderFactory = new BuilderFactory();
        $this->planetRepository = $this->createMock(PlanetRepositoryInterface::class);
        $this->listPlanetQueryHandler = new ListPlanetQueryHandler($this->planetRepository);
    }

    /** @test */
    public function should_return_all_planets_when_no_filter(): void
    {
        $mars = $this->builderFactory->planet()
            ->withName('Mars')
            ->build();

        $earth = $this->builderFactory->planet()
            ->withName('Earth')
            ->build();

        $this->planetRepository
            ->expects($this->exactly(2))
            ->method('findByCriteria')
            ->willReturn([$mars, $earth]);

        $query = new ListPlanetQuery();
        $planets = $this->listPlanetQueryHandler->handle($query);

        $this->assertEquals('Mars', $planets->results()[0]->name());
        $this->assertEquals('Earth', $planets->results()[1]->name());
    }

    /** @test */
    public function should_return_planet_filtered(): void
    {
        $this->builderFactory->planet()
            ->withName('Mars')
            ->build();

        $earth = $this->builderFactory->planet()
            ->withName('Earth')
            ->build();

        $this->planetRepository
            ->expects($this->exactly(2))
            ->method('findByCriteria')
            ->willReturn([$earth]);

        $query = new ListPlanetQuery('Earth');
        $planets = $this->listPlanetQueryHandler->handle($query);

        $this->assertCount(1, $planets->results());
        $this->assertEquals('Earth', $planets->results()[0]->name());
    }
}