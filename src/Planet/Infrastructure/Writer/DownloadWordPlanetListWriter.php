<?php declare(strict_types=1);

namespace Planet\Infrastructure\Writer;

use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\TemplateProcessor;
use Planet\Domain\Writer\DownloadWordPlanetListWriterInterface;
use Shared\Infrastructure\Writer\PhpWordWriter;

class DownloadWordPlanetListWriter extends PhpWordWriter implements DownloadWordPlanetListWriterInterface
{
    public const FILENAME = 'planet_list.docx';

    public function __construct(
        private string $template,
        private string $folder
    ) {
        parent::__construct($template, $folder, self::FILENAME);
    }

    /**
     * @throws Exception
     */
    public function updateTemplate(TemplateProcessor $templateProcessor, $data): void
    {
        $planets = $data['planets'];

        $templateProcessor->cloneBlock('PLANETS_BLOCK', 1, true, true);
        $templateProcessor->cloneRow('PLANET#1', count($planets));

        $index = 1;
        foreach ($planets as $planet) {
            $templateProcessor->setValue('PLANET#1#' . $index, $planet['name']);

            $index++;
        }
    }
}
