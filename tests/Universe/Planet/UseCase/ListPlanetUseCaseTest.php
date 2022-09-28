<?php
declare(strict_types=1);

namespace Tests\Universe\Planet\UseCase;

use Tests\Common\Builder\Planet\PlanetBuilder;
use Tests\Common\Controller\BaseWebTestCase;
use Universe\Planet\Exception\PlanetsNotFoundException;
use Exception;
use Universe\Planet\Repository\PlanetRepository;
use Universe\Planet\UseCase\ListPlanetsUseCase;

class ListPlanetUseCaseTest extends BaseWebTestCase
{
    private PlanetBuilder $planetBuilder;
    private PlanetRepository $planetRepository;
    private ListPlanetsUseCase $listPlanetsUseCase;

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->planetBuilder = new PlanetBuilder($this->entityManager);
        $this->planetRepository = $this->testContainer->get(PlanetRepository::class);
        $this->listPlanetsUseCase = new ListPlanetsUseCase($this->planetRepository);
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

        $this->listPlanetsUseCase->handle('Jupiter');
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

        $planets = $this->listPlanetsUseCase->handle();

        $this->assertEquals('Mars', $planets[0]);
        $this->assertEquals('Earth', $planets[1]);
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

        $planets = $this->listPlanetsUseCase->handle('Earth');

        $this->assertCount(1, $planets);
        $this->assertEquals('Earth', $planets[0]);
    }
}