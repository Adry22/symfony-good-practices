<?php

declare(strict_types=1);

namespace Planet\Application\Query\DownloadExcelPlanetList;

use Monolog\Test\TestCase;
use Planet\Domain\Repository\PlanetRepositoryInterface;
use Planet\Infrastructure\Writer\DownloadExcelPlanetListWriter;
use Tests\Common\Builder\BuilderFactory;

class DownloadExcelPlanetListQueryHandlerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->builderFactory = new BuilderFactory();
        $this->planetRepository = $this->createMock(PlanetRepositoryInterface::class);
        $this->downloadExcelPlanetListWriter = $this->createMock(DownloadExcelPlanetListWriter::class);

        $this->downloadExcelPlanetListQueryHandler = new DownloadExcelPlanetListQueryHandler(
            $this->planetRepository,
            $this->downloadExcelPlanetListWriter
        );
    }

    /** @test */
    public function given_a_list_of_planets_should_return_them_when_everything_is_ok(): void
    {
        $mars = $this->builderFactory->planet()
            ->withName('Mars')
            ->build();

        $earth = $this->builderFactory->planet()
            ->withName('Earth')
            ->build();

        $this->planetRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([$mars, $earth]);

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