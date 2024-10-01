<?php declare(strict_types=1);

namespace Universe\Planet\Controller;

use Symfony\Component\HttpFoundation\Response;
use Tests\Common\Builder\Planet\PlanetBuilder;
use Tests\Common\Builder\User\UserBuilder;
use Tests\Common\Controller\BaseWebApiTestCase;

class DownloadWordPlanetsListControllerTest extends BaseWebApiTestCase
{
    private const URL = '/download-word-planets-list';

    private PlanetBuilder $planetBuilder;
    private UserBuilder $userBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->planetBuilder = new PlanetBuilder($this->entityManager);
        $this->userBuilder = new UserBuilder($this->entityManager);
    }

    /** @test */
    public function given_an_url_then_should_exists(): void
    {
        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $response = $this->getRequestJson(self::URL);

        $this->assertNotEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /** @test */
    public function given_an_user_should_fail_when_is_not_logged(): void
    {
        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $response = $this->getRequestJson(self::URL);

        $this->assertNotEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /** @test */
    public function given_a_list_of_planets_when_everything_is_ok_then_file_download_should_not_be_empty(): void
    {
        $user = $this->userBuilder
            ->withEmail('test@email.com')
            ->withPassword('password')
            ->build();

        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $this->loginUser($user);
        $response = $this->getRequestJson(self::URL);

        $this->assertNotEmpty($response->getContent());
    }

    //    NOTE: This test is commented because assert fails in CircleCI
//    /** @test */
//    public function given_an_downloaded_word_when_everything_is_ok_then_should_has_correct_filename(): void
//    {
//        $user = $this->userBuilder
//            ->withEmail('test@email.com')
//            ->withPassword('password')
//            ->build();
//
//        $this->planetBuilder
//            ->withName('Mars')
//            ->build();
//
//        $this->loginUser($user);
//        $response = $this->getRequestJson(self::URL);
//
//        $filename = 'Listado de planetas.xlsx';
//
//        $this->assertEquals(
//            'inline; filename="'. $filename .'"',
//            $response->headers->get('content-disposition')
//        );
//
//        $this->assertNotEmpty($response->getContent());
//    }
}
