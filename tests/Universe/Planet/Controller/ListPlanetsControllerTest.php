<?php
declare(strict_types=1);

namespace Tests\Universe\Planet\Controller;

use Symfony\Component\HttpFoundation\Response;
use Tests\Common\Builder\Planet\PlanetBuilder;
use Tests\Common\Controller\BaseWebApiTestCase;

class ListPlanetsControllerTest extends BaseWebApiTestCase
{
    private const URL = '/planets';

    private PlanetBuilder $planetBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->planetBuilder = new PlanetBuilder($this->entityManager);
    }

    /** @test */
    public function should_exists_url(): void
    {
        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $response = $this->getRequestJson(self::URL);

        $this->assertNotEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /** @test */
    public function should_fail_when_planet_not_exists(): void
    {
        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $parameters = [
            'name' => 'Earth'
        ];

        $this->getRequestJson(self::URL, $parameters);

        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $content['code']);
        $this->assertEquals('PlanetsNotFoundException', $content['type']);
        $this->assertEquals('Planets not found exception', $content['message']);
    }

    /** @test */
    public function should_return_data_when_everything_is_correct(): void
    {
        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $parameters = [
            'name' => 'Mars'
        ];

        $this->getRequestJson(self::URL, $parameters);

        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertCount(1, $content);
        $this->assertEquals('Mars', $content[0]);
    }
}