<?php declare(strict_types=1);

namespace Universe\Planet\Query\DownloadWordPlanetList;

use Universe\Planet\Formatter\DownloadPlanetListFormatter;
use Universe\Planet\Repository\PlanetRepositoryInterface;
use Universe\Planet\Writer\DownloadWordPlanetListWriter;
use Universe\Shared\Bus\Query\QueryHandler;

class DownloadWordPlanetListQueryHandler implements QueryHandler
{
    public const FILENAME = 'planets_list';

    public function __construct(
        private PlanetRepositoryInterface $planetRepository,
        private DownloadWordPlanetListWriter $writer
    ) {
    }

    public function handle(DownloadWordPlanetListQuery $query): DownloadWordPlanetListResult
    {
        $planets = $this->planetRepository->findAll();

        $formatter = new DownloadPlanetListFormatter($planets);
        $file = $this->writer->generate($formatter->toArray());

        return DownloadWordPlanetListResult::create($this->makeFilename(), $file);
    }

    private function makeFilename(): string
    {
        return self::FILENAME;
    }
}