<?php

declare(strict_types=1);

namespace Planet\Application\Query\DownloadExcelPlanetList;

use Planet\Domain\Repository\PlanetRepositoryInterface;
use Planet\Infrastructure\Writer\DownloadExcelPlanetListWriter;
use Tests\Common\Builder\Planet\PlanetBuilder;
use Tests\Common\Controller\BaseWebTestCase;

class DownloadExcelPlanetListQueryHandlerTest extends BaseWebTestCase
{
    private PlanetBuilder $planetBuilder;
    private PlanetRepositoryInterface $planetRepository;
    private DownloadExcelPlanetListQueryHandler $downloadExcelPlanetListQueryHandler;

    public function setUp(): void
    {
        parent::setUp();

        $this->planetBuilder = new PlanetBuilder($this->entityManager);
        $this->planetRepository = $this->testContainer->get(PlanetRepositoryInterface::class);
        $this->downloadExcelPlanetListWriter = $this->getMockBuilder(DownloadExcelPlanetListWriter::class)->disableOriginalConstructor()->getMock();

        $this->downloadExcelPlanetListQueryHandler = new DownloadExcelPlanetListQueryHandler(
            $this->planetRepository,
            $this->downloadExcelPlanetListWriter
        );
    }

    /** @test */
    public function given_a_list_of_planets_should_return_them_when_everything_is_ok(): void
    {
        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $this->planetBuilder
            ->reset()
            ->withName('Earth')
            ->build();

        $query = new DownloadExcelPlanetListQuery();

        $this->assertWriterParameters($query, function($data) {
            $this->assertCount(2, $data['planets']);
            $this->assertEquals('Mars', $data['planets'][0]['name']);
            $this->assertEquals('Earth', $data['planets'][1]['name']);

            return '';
        });
    }

    private function assertWriterParameters(DownloadExcelPlanetListQuery $query, $callback)
    {
        $this->downloadExcelPlanetListWriter
            ->expects($this->once())
            ->method('generate')
            ->willReturnCallback($callback);

        $this->downloadExcelPlanetListQueryHandler->handle($query);
    }
}