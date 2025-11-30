<?php

declare(strict_types=1);

namespace Planet\Application\Query\DownloadWordPlanetList;

use Planet\Domain\Formatter\DownloadPlanetListFormatter;
use Planet\Domain\Repository\PlanetRepositoryInterface;
use Planet\Domain\Writer\DownloadWordPlanetListWriterInterface;
use Universe\Shared\Bus\Query\QueryHandler;

class DownloadWordPlanetListQueryHandler implements QueryHandler
{
    public const FILENAME = 'planets_list';

    public function __construct(
        private PlanetRepositoryInterface $planetRepository,
        private DownloadWordPlanetListWriterInterface $writer
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