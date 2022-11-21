<?php
declare(strict_types=1);
namespace Universe\Planet\Query\DownloadExcelPlanetList;

use Universe\Planet\Formatter\DownloadExcelPlanetListFormatter;
use Universe\Planet\Repository\PlanetRepository;
use Universe\Planet\Writer\DownloadExcelPlanetListWriter;
use Universe\Shared\Bus\Query\QueryHandler;

class DownloadExcelPlanetListQueryHandler implements QueryHandler
{
    public const FILENAME = 'Listado de planetas';

    private PlanetRepository $planetRepository;
    private DownloadExcelPlanetListWriter $writer;

    public function __construct(
        PlanetRepository $planetRepository,
        DownloadExcelPlanetListWriter $writer
    ) {
        $this->planetRepository = $planetRepository;
        $this->writer = $writer;
    }

    public function handle(DownloadExcelPlanetListQuery $query): DownloadExcelPlanetListResult
    {
        $planets = $this->planetRepository->findAll();

        $formatter = new DownloadExcelPlanetListFormatter($planets);
        $file = $this->writer->generate($formatter->toArray());

        return DownloadExcelPlanetListResult::create($this->makeFilename(), $file);
    }

    private function makeFilename(): string
    {
        return self::FILENAME;
    }
}