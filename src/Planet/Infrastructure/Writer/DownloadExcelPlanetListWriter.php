<?php

namespace Planet\Infrastructure\Writer;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Planet\Domain\Writer\DownloadExcelPlanetListWriterInterface;

class DownloadExcelPlanetListWriter implements DownloadExcelPlanetListWriterInterface
{
    private Spreadsheet $spreadsheet;
    private Worksheet $activeSheet;
    private string $temporalFolder;

    public const INITIAL_ROW_NUMBER = 1;
    public const INITIAL_COL_CHAR = 'A';

    private int $rowNumber = self::INITIAL_ROW_NUMBER;
    private string $colChar = self::INITIAL_COL_CHAR;

    public function __construct(
        string $temporalFolder
    ) {
        $this->temporalFolder = $temporalFolder;

        $this->spreadsheet = new Spreadsheet();
        $this->spreadsheet->getProperties()
            ->setCreator("Fynkus")
            ->setTitle("");

        $this->activeSheet = $this->spreadsheet->getActiveSheet();
    }

    public function generate(array $data): string
    {
        $spreadsheet = $this->makeFile($data);
        return $this->generateFile($spreadsheet);
    }

    private function makeFile(array $data): Spreadsheet
    {
        $this->makeTitles($data['titles']);
        $this->makeColumnsNames($data['columns']);
        $this->makeRows($data['planets'], $data['columns']);

        return $this->spreadsheet;
    }

    private function makeTitles(array $titles): void
    {
        $this->cellStyleTitle($this->colChar);
        $this->activeSheet->setCellValue($this->colChar . $this->rowNumber, $titles['main_title']);
        $this->newLine();
    }

    private function makeColumnsNames(array $columns): void
    {
        foreach ($columns as $column) {
            $this->activeSheet->setCellValue($this->colChar . $this->rowNumber, $column);
            $this->cellStyleTableColumnHeader($this->colChar);
            $this->newCol();
        }

        $this->tableHeaderStyle();
        $this->newLine();
    }

    private function makeRows(array $lines, array $columns): void
    {
        foreach ($lines as $line) {
            foreach ($columns as $columnKey => $column) {
                $this->activeSheet->setCellValue($this->colChar . $this->rowNumber, $line[$columnKey]->toString());
                $this->textCellStyle();
                $this->newCol();
            }

            $this->newLine();
        }
    }

    private function textCellStyle(): void
    {
        $style = $this->activeSheet->getCell($this->colChar . $this->rowNumber)->getStyle();
        $style->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
    }

    private function cellStyleTableColumnHeader(string $columnLetter): void
    {
        $headerStyle = $this->activeSheet->getCell($columnLetter . $this->rowNumber)->getStyle();
        $headerStyle->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headerStyle->getFont()->setBold(true);
    }

    private function newCol(): void
    {
        $this->colChar++;
    }

    private function tableHeaderStyle(): void
    {
        foreach (range('A', $this->activeSheet->getHighestDataColumn()) as $col) {
            $this->cellStyleTableHeader($col);
        }
    }

    private function cellStyleTableHeader(string $columnLetter): void
    {
        $headerStyle = $this->activeSheet->getCell($columnLetter . $this->rowNumber)->getStyle();
        $headerStyle->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFont()->setSize(14);

        $this->activeSheet->getRowDimension($this->rowNumber)->setRowHeight(30);
    }

    private function cellStyleTitle(string $columnLetter): void
    {
        $headerStyle = $this->activeSheet->getCell($columnLetter . $this->rowNumber)->getStyle();

        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFont()->setSize(16);

        $this->activeSheet->getRowDimension($this->rowNumber)->setRowHeight(20);
    }

    private function newLine(): void
    {
        $this->rowNumber++;
        $this->colChar = self::INITIAL_COL_CHAR;
    }

    private function generateFile($spreadsheet): string
    {
        $filename = $this->makeFilename();

        $spreadSheetWriter = new Xlsx($spreadsheet);

        $spreadSheetWriter->save($filename);

        $file = $this->readFile($filename);
        $this->deleteFile($filename);

        return $file;
    }

    private function makeFilename(): string
    {
        $timestamp = (new \DateTime())->getTimestamp();
        return $this->temporalFolder . DIRECTORY_SEPARATOR . $timestamp . '.xlsx';
    }

    private function readFile($filename): string
    {
        return file_get_contents($filename);
    }

    private function deleteFile($filename): void
    {
        @unlink($filename);
    }
}