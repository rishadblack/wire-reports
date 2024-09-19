<?php

namespace Rishadblack\WireReports\Traits;

use Illuminate\Support\Str;

trait ComponentHelpers
{
    protected $report_view;
    protected $pdf_view = 'wire-reports::export-layouts.pdf';
    protected $excel_view = 'wire-reports::export-layouts.excel';

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


        // Extract class name from the trait's context
        $className = class_basename($this);

        // Convert class name to kebab case for view file naming
        $viewName = Str::kebab($className);

        // Assuming the view file is in 'livewire/reports' directory
        return "livewire/reports/{$viewName}";
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




}
