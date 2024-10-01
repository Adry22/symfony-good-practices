<?php
declare(strict_types=1);
namespace Universe\Planet\Query\DownloadExcelPlanetList;

use Universe\Planet\Formatter\DownloadPlanetListFormatter;
use Universe\Planet\Repository\PlanetRepositoryInterface;
use Universe\Planet\Writer\DownloadExcelPlanetListWriter;
use Universe\Shared\Bus\Query\QueryHandler;

class DownloadExcelPlanetListQueryHandler implements QueryHandler
{
    public const FILENAME = 'planets_list';

    private PlanetRepositoryInterface $planetRepository;
    private DownloadExcelPlanetListWriter $writer;

    public function __construct(
        PlanetRepositoryInterface $planetRepository,
        DownloadExcelPlanetListWriter $writer
    ) {
        $this->planetRepository = $planetRepository;
        $this->writer = $writer;
    }

    public function handle(DownloadExcelPlanetListQuery $query): DownloadExcelPlanetListResult
    {
        $planets = $this->planetRepository->findAll();

        $formatter = new DownloadPlanetListFormatter($planets);
        $file = $this->writer->generate($formatter->toArray());

        return DownloadExcelPlanetListResult::create($this->makeFilename(), $file);
    }

    private function makeFilename(): string
    {
        return self::FILENAME;
    }
}