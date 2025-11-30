<?php

declare(strict_types=1);

namespace Planet\Domain\Writer;

interface DownloadExcelPlanetListWriterInterface
{
    public function generate(array $data): string;
}
