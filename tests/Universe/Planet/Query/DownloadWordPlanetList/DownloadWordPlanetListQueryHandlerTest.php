<?php declare(strict_types=1);

namespace Universe\Planet\Query\DownloadWordPlanetList;

use Tests\Common\Builder\Planet\PlanetBuilder;
use Tests\Common\Controller\BaseWebTestCase;
use Universe\Planet\Repository\PlanetRepositoryInterface;
use Universe\Planet\Writer\DownloadWordPlanetListWriter;

class DownloadWordPlanetListQueryHandlerTest extends BaseWebTestCase
{
    private PlanetBuilder $planetBuilder;
    private PlanetRepositoryInterface $planetRepository;
    private DownloadWordPlanetListQueryHandler $handler;

    public function setUp(): void
    {
        parent::setUp();

        $this->planetBuilder = new PlanetBuilder($this->entityManager);
        $this->planetRepository = $this->testContainer->get(PlanetRepositoryInterface::class);
        $this->downloadWordPlanetListWriter = $this->getMockBuilder(DownloadWordPlanetListWriter::class)->disableOriginalConstructor()->getMock();

        $this->handler = new DownloadWordPlanetListQueryHandler(
            $this->planetRepository,
            $this->downloadWordPlanetListWriter
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
