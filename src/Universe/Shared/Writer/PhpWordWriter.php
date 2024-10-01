<?php declare(strict_types=1);

namespace Universe\Shared\Writer;

use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;

abstract class PhpWordWriter
{
    protected TemplateProcessor $processor;

    /**
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     */
    public function __construct(
        private string $template,
        private string $folder,
        private string $filename
    ) {
        $this->processor = new TemplateProcessor($template);
    }

    abstract public function updateTemplate(TemplateProcessor $templateProcessor, $data);

    public function generate($data): string
    {
        $this->updateTemplate($this->processor, $data);

        return $this->generateFile();
    }

    protected function generateFile(): string
    {
        $filename = $this->makeFilename();
        $this->processor->saveAs($filename);

        $file = $this->readFile($filename);
        $this->deleteFile($filename);

        return $file;
    }

    protected function makeFilename(): string
    {
        return $this->folder . DIRECTORY_SEPARATOR . $this->filename;
    }

    protected function readFile($filename): string
    {
        return file_get_contents($filename);
    }

    protected function deleteFile($filename): void
    {
        @unlink($filename);
    }
}