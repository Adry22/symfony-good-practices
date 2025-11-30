<?php

declare(strict_types=1);

namespace Planet\Application\Query\DownloadExcelPlanetList;

use Universe\Shared\Bus\Query\Result;

class DownloadExcelPlanetListResult implements Result
{
    private string $filename;
    private string $fileContent;

    private function __construct(string $filename, string $fileContent)
    {
        $this->filename = $filename;
        $this->fileContent = $fileContent;
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