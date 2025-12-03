<?php

declare(strict_types=1);

namespace Planet\Application\Query\DownloadExcelPlanetList;

use Planet\Domain\Formatter\DownloadPlanetListFormatter;
use Planet\Domain\Repository\PlanetRepositoryInterface;
use Planet\Domain\Writer\DownloadExcelPlanetListWriterInterface;
use Shared\Domain\Bus\Query\QueryHandler;

class DownloadExcelPlanetListQueryHandler implements QueryHandler
{
    public const FILENAME = 'planets_list';

    private PlanetRepositoryInterface $planetRepository;
    private DownloadExcelPlanetListWriterInterface $writer;

    public function __construct(
        PlanetRepositoryInterface $planetRepository,
        DownloadExcelPlanetListWriterInterface $writer
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