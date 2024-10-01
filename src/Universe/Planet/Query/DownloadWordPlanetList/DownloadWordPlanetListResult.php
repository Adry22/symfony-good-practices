<?php declare(strict_types=1);

namespace Universe\Planet\Query\DownloadWordPlanetList;

use Universe\Shared\Bus\Query\Result;

class DownloadWordPlanetListResult implements Result
{
    private function __construct(
        private string $filename,
        private string $fileContent
    ) {
    }

    public static function create(string $filename, string $fileContent): self
    {
        return new self($filename, $fileContent);
    }

    public function filename(): string
    {
        return $this->filename;
    }

    public function fileContent(): string
    {
        return $this->fileContent;
    }
}