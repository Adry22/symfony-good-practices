<?php

declare(strict_types=1);

namespace Planet\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;
use Tests\Common\Builder\Planet\PlanetBuilder;
use Tests\Common\Builder\User\UserBuilder;
use Tests\Common\Controller\BaseWebApiTestCase;

class ListPlanetsControllerTest extends BaseWebApiTestCase
{
    private const URL = '/planets';

    private PlanetBuilder $planetBuilder;
    private UserBuilder $userBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->planetBuilder = new PlanetBuilder($this->entityManager);
        $this->userBuilder = new UserBuilder($this->entityManager);
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
    public function should_return_data_without_filter_when_there_is_no_filter(): void
    {
        $user = $this->userBuilder
            ->withEmail('test@email.com')
            ->withPassword('password')
            ->build();

        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $this->planetBuilder
            ->withName('Earth')
            ->build();

        $this->loginUser($user);
        $this->getRequestJson(self::URL);

        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertCount(2, $content['results']);
        $this->assertEquals('Mars', $content['results'][0]['name']);
        $this->assertEquals('Earth', $content['results'][1]['name']);
    }

    /** @test */
    public function should_return_data_filtered_when_everything_is_correct(): void
    {
        $user = $this->userBuilder
            ->withEmail('test@email.com')
            ->withPassword('password')
            ->build();

        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $parameters = [
            'name' => 'Mars'
        ];

        $this->loginUser($user);
        $this->getRequestJson(self::URL, $parameters);

        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertCount(1, $content['results']);
        $this->assertEquals('Mars', $content['results'][0]['name']);
    }
}