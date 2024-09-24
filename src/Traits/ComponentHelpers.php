<?php

namespace Rishadblack\WireReports\Traits;

use Illuminate\Support\Str;
use Livewire\Features\SupportConsoleCommands\Commands\ComponentParser;

trait ComponentHelpers
{
    protected $report_view;
    protected $button_view;
    protected $pdf_view = 'wire-reports::export-layouts.pdf';
    protected $excel_view = 'wire-reports::export-layouts.excel';
    protected $file_name;
    protected $file_title;
    protected $pagination = 10;
    protected $paper_size;
    protected $orientation;

    public function setReportView(string $reportView)
    {
        $this->report_view = $reportView;
        return $this;
    }

    public function getReportView(): string
    {
        if ($this->report_view) {
            return $this->report_view;
        }

        // Get the full class name of the current instance
        $fullClassName = get_class($this);

        // Extract the namespace parts
        $namespaceParts = explode('\\', $fullClassName);
        $reportIndex = array_search('Reports', $namespaceParts);

        // Check if 'Reports' exists in the namespace
        if ($reportIndex !== false) {
            // Extract everything after 'Reports'
            $subNamespaceParts = array_slice($namespaceParts, $reportIndex);

            // Combine sub-namespace and view name to create the view path
            $subNamespace = implode('.', $subNamespaceParts);

            // Use ComponentParser to construct the parser
            $parser = new ComponentParser(
                config('livewire.class_namespace'),
                config('livewire.view_path'),
                $subNamespace
            );

            return str_replace('.', '/', $parser->viewName()); // Return the view path
        }

        // Handle case where 'Reports' is not found in the namespace
        throw new \Exception("Reports namespace not found in class: {$fullClassName}");
    }

    public function setButtonView(string $buttonView)
    {
        $this->button_view = $buttonView;
        return $this;
    }

    public function getButtonView(): string|null
    {
        return $this->button_view;
    }

    public function setPdfView(string $pdfView)
    {
        $this->pdf_view = $pdfView;
        return $this;
    }

    public function getPdfView(): string
    {
        return $this->pdf_view;
    }

    public function setExcelView(string $excelView)
    {
        $this->excel_view = $excelView;
        return $this;
    }

    public function getExcelView(): string
    {
        return $this->excel_view;
    }

    public function setFileName(string $fileName)
    {
        $this->file_name = $fileName;
        return $this;
    }

    public function getFileName(): string
    {
        return $this->file_name ?? config('wire-reports.default_download_file_name');
    }

    public function setFileTitle(string $fileTitle)
    {
        $this->file_title = $fileTitle;
        return $this;
    }

    public function getFileTitle(): string
    {
        return $this->file_title ?? Str::title(Str::snake($this->getFileName(), config('wire-reports.default_download_file_name')));
    }

    public function setPagination(int $pagination)
    {
        $this->pagination = $pagination;
        return $this;
    }

    public function getPagination(): int
    {
        return $this->pagination;
    }

    public function setPaperSize(string $paperSize)
    {
        $this->paper_size = $paperSize;
        return $this;
    }

    public function getPaperSize(): string
    {
        return $this->paper_size ?? config('wire-reports.pdf_paper_size');
    }

    public function setOrientation(string $orientation)
    {
        $this->orientation = $orientation;
        return $this;
    }

    public function getOrientation(): string
    {
        return $this->orientation ?? config('wire-reports.pdf_orientation');
    }

    public function getFilter(string $filterName): string|bool
    {
        return isset($this->filters[$filterName]) ? $this->filters[$filterName] : false;
    }
}
