<?php

declare(strict_types=1);

namespace Planet\Infrastructure\Controller;

use Planet\Domain\Repository\PlanetRepositoryInterface;
use Shared\Domain\ValueObject\Email;
use Symfony\Component\HttpFoundation\Response;
use Tests\Common\Controller\BaseWebApiTestCase;
use User\Domain\Entity\User\Password\Password;

class ListPlanetsControllerTest extends BaseWebApiTestCase
{
    private const URL = '/planets';

    public function setUp(): void
    {
        parent::setUp();

        $this->planetRepository = $this->testContainer->get(PlanetRepositoryInterface::class);
    }

    /** @test */
    public function should_exists_url(): void
    {
        $this->builderFactory()->planet()
            ->withName('Mars')
            ->build();

        $response = $this->getRequestJson(self::URL);

        $this->assertNotEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /** @test */
    public function should_return_data_without_filter_when_there_is_no_filter(): void
    {
        $user = $this->builderFactory()->user()
            ->withEmail(new Email('test@email.com'))
            ->withPassword(new Password('password'))
            ->build();

        $mars = $this->builderFactory()->planet()
            ->withName('Mars')
            ->build();

        $this->planetRepository->save($mars);

        $earth = $this->builderFactory()->planet()
            ->withName('Earth')
            ->build();

        $this->planetRepository->save($earth);
        $this->planetRepository->flush();

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
        $user = $this->builderFactory()->user()
            ->withEmail(new Email('test@email.com'))
            ->withPassword(new Password('password'))
            ->build();

        $mars = $this->builderFactory()->planet()
            ->withName('Mars')
            ->build();

        $this->planetRepository->save($mars);

        $earth = $this->builderFactory()->planet()
            ->withName('Earth')
            ->build();

        $this->planetRepository->save($earth);
        $this->planetRepository->flush();

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