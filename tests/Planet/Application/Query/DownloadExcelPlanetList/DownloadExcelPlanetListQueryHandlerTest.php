<?php

declare(strict_types=1);

namespace Planet\Application\Query\DownloadExcelPlanetList;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Planet\Domain\Repository\PlanetRepositoryInterface;
use Planet\Domain\Writer\DownloadExcelPlanetListWriterInterface;
use Tests\Common\Builder\BuilderFactory;

class DownloadExcelPlanetListQueryHandlerTest extends TestCase
{
    private BuilderFactory $builderFactory;
    private PlanetRepositoryInterface&MockObject $planetRepository;
    private DownloadExcelPlanetListWriterInterface&MockObject $writer;
    private DownloadExcelPlanetListQueryHandler $handler;

    public function setUp(): void
    {
        parent::setUp();

        $this->builderFactory = new BuilderFactory();
        $this->planetRepository = $this->createMock(PlanetRepositoryInterface::class);
        $this->writer = $this->createMock(DownloadExcelPlanetListWriterInterface::class);

        $this->handler = new DownloadExcelPlanetListQueryHandler(
            $this->planetRepository,
            $this->writer
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
            $this->assertEquals('Mars', $data['planets'][0]['name']->toString());
            $this->assertEquals('Earth', $data['planets'][1]['name']->toString());

            return '';
        });
    }

    private function assertWriterParameters(DownloadExcelPlanetListQuery $query, $callback)
    {
        $this->writer
            ->expects($this->once())
            ->method('generate')
            ->willReturnCallback($callback);

        $this->handler->handle($query);
    }
}