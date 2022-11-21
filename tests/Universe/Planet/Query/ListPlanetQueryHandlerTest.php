<?php
declare(strict_types=1);
namespace Tests\Universe\Planet\Query;

use Exception;
use Tests\Common\Builder\Planet\PlanetBuilder;
use Tests\Common\Controller\BaseWebTestCase;
use Universe\Planet\Exception\PlanetsNotFoundException;
use Universe\Planet\Query\ListPlanet\ListPlanetQuery;
use Universe\Planet\Query\ListPlanet\ListPlanetQueryHandler;
use Universe\Planet\Repository\PlanetRepository;

class ListPlanetQueryHandlerTest extends BaseWebTestCase
{
    private PlanetBuilder $planetBuilder;
    private PlanetRepository $planetRepository;
    private ListPlanetQueryHandler $listPlanetQueryHandler;

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->planetBuilder = new PlanetBuilder($this->entityManager);
        $this->planetRepository = $this->testContainer->get(PlanetRepository::class);
        $this->listPlanetQueryHandler = new ListPlanetQueryHandler($this->planetRepository);
    }

    /** @test
     * @throws Exception
     */
    public function should_fail_when_no_planets_found(): void
    {
        $this->expectException(PlanetsNotFoundException::class);

        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $query = new ListPlanetQuery('Jupiter');
        $this->listPlanetQueryHandler->handle($query);
    }

    /** @test */
    public function should_return_all_planets_when_no_filter(): void
    {
        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $this->planetBuilder
            ->reset()
            ->withName('Earth')
            ->build();

        $query = new ListPlanetQuery();
        $planets = $this->listPlanetQueryHandler->handle($query);

        $this->assertEquals('Mars', $planets->results()[0]->name());
        $this->assertEquals('Earth', $planets->results()[1]->name());
    }

    /** @test */
    public function should_return_planet_filtered(): void
    {
        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $this->planetBuilder
            ->reset()
            ->withName('Earth')
            ->build();

        $query = new ListPlanetQuery('Earth');
        $planets = $this->listPlanetQueryHandler->handle($query);

        $this->assertCount(1, $planets->results());
        $this->assertEquals('Earth', $planets->results()[0]->name());
    }
}