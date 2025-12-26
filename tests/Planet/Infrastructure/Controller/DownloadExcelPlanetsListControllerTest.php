<?php

declare(strict_types=1);

namespace Planet\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;
use Tests\Common\Controller\BaseWebApiTestCase;

class DownloadExcelPlanetsListControllerTest extends BaseWebApiTestCase
{
    private const URL = '/download-excel-planets-list';

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
}
