<?php declare(strict_types=1);

namespace Planet\Application\Query\DownloadWordPlanetList;

use Monolog\Test\TestCase;
use Planet\Domain\Repository\PlanetRepositoryInterface;
use Planet\Infrastructure\Writer\DownloadWordPlanetListWriter;
use Tests\Common\Builder\BuilderFactory;

class DownloadWordPlanetListQueryHandlerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->builderFactory = new BuilderFactory();
        $this->planetRepository = $this->createMock(PlanetRepositoryInterface::class);
        $this->downloadWordPlanetListWriter = $this->createMock(DownloadWordPlanetListWriter::class);

        $this->handler = new DownloadWordPlanetListQueryHandler(
            $this->planetRepository,
            $this->downloadWordPlanetListWriter
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
            $this->assertEquals('Mars', $data['planets'][0]['name']);
            $this->assertEquals('Earth', $data['planets'][1]['name']);

            return '';
        });
    }

    private function assertWriterParameters(DownloadWordPlanetListQuery $query, $callback)
    {
        $this->downloadWordPlanetListWriter
            ->expects($this->once())
            ->method('generate')
            ->willReturnCallback($callback);

        $this->handler->handle($query);
    }
}
