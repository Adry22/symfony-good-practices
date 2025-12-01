<?php

declare(strict_types=1);

namespace Planet\Domain\Writer;

use PhpOffice\PhpWord\TemplateProcessor;

interface DownloadWordPlanetListWriterInterface
{
    // TODO: remove this interface in handler cause of phpoffice dependency
    public function updateTemplate(TemplateProcessor $templateProcessor, $data): void;
}
