<?php declare(strict_types=1);

namespace Planet\Application\Query\DownloadWordPlanetList;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Planet\Domain\Repository\PlanetRepositoryInterface;
use Planet\Domain\Writer\DownloadWordPlanetListWriterInterface;
use Tests\Common\Builder\BuilderFactory;

class DownloadWordPlanetListQueryHandlerTest extends TestCase
{
    private BuilderFactory $builderFactory;
    private PlanetRepositoryInterface&MockObject $planetRepository;
    private DownloadWordPlanetListWriterInterface&MockObject $writer;
    private DownloadWordPlanetListQueryHandler $handler;

    public function setUp(): void
    {
        parent::setUp();

        $this->builderFactory = new BuilderFactory();
        $this->planetRepository = $this->createMock(PlanetRepositoryInterface::class);
        $this->writer = $this->createMock(DownloadWordPlanetListWriterInterface::class);

        $this->handler = new DownloadWordPlanetListQueryHandler(
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

        $query = new DownloadWordPlanetListQuery();

        $this->assertWriterParameters($query, function($data) {
            $this->assertCount(2, $data['planets']);
            $this->assertEquals('Mars', $data['planets'][0]['name']->toString());
            $this->assertEquals('Earth', $data['planets'][1]['name']->toString());

            return '';
        });
    }

    private function assertWriterParameters(DownloadWordPlanetListQuery $query, $callback)
    {
        $this->writer
            ->expects($this->once())
            ->method('write')
            ->willReturnCallback($callback);

        $this->handler->handle($query);
    }
}
