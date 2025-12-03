<?php

declare(strict_types=1);

namespace Planet\Domain\Writer;

interface DownloadWordPlanetListWriterInterface
{
    public function write(array $data): string;
}
