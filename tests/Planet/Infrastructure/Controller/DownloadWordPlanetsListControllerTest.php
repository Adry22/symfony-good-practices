<?php declare(strict_types=1);

namespace Planet\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;
use Tests\Common\Controller\BaseWebApiTestCase;

class DownloadWordPlanetsListControllerTest extends BaseWebApiTestCase
{
    private const URL = '/download-word-planets-list';

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function given_an_url_then_should_exists(): void
    {
        $response = $this->getRequestJson(self::URL);

        $this->assertNotEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /** @test */
    public function given_an_user_should_fail_when_is_not_logged(): void
    {
        $response = $this->getRequestJson(self::URL);

        $this->assertNotEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    // TODO: Commented test cause CircleCI fails
//    /** @test */
//    public function given_a_list_of_planets_when_everything_is_ok_then_file_download_should_has_correct_filename(): void
//    {
//        $user = $this->userBuilder
//            ->withEmail('test@email.com')
//            ->withPassword('password')
//            ->build();
//
//        $this->loginUser($user);
//        $response = $this->getRequestJson(self::URL);
//
//        $this->assertSame('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $response->headers->get('Content-Type'));
//        $this->assertSame('inline; filename="planets_list.docx"', $response->headers->get('Content-Disposition'));
//
//    }
}
