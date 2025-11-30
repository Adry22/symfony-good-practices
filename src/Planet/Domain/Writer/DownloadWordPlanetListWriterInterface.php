<?php

declare(strict_types=1);

namespace Planet\Domain\Writer;

use PhpOffice\PhpWord\TemplateProcessor;

interface DownloadWordPlanetListWriterInterface
{
    public function updateTemplate(TemplateProcessor $templateProcessor, $data): void;
}
