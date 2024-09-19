<?php

namespace Rishadblack\WireReports;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Database\Eloquent\Builder;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Rishadblack\WireReports\Exports\ReportExport;
use Rishadblack\WireReports\Traits\ComponentHelpers;

abstract class ReportComponent extends Component
{
    use WithPagination;
    use ComponentHelpers;

    public $pdf_export_by = 'snappy'; // snappy or mpdf
    public $download_file_name = 'report';

    public function baseBuilder(): Builder
    {
        return $this->builder();
    }

    public function exportPdf()
    {
        try {
            if ($this->pdf_export_by == 'mpdf') {
                return $this->pdfExportByMpdf();
            } else {
                return $this->pdfExportBySnappy();
            }
        } catch (\Exception $e) {
            // Handle error
            dd('PDF generation error: ' . $e->getMessage());
        }
    }

    public function exportExcel()
    {
        $class = new ReportExport();
        $class->setCurrentView($this->getExcelView());
        $class->setCurrentData($this->returnViewData());

        return Excel::download($class, 'report-'.now()->format('d-m-y-h-i').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    abstract public function builder(): Builder;

    public function returnViewData($pagination = false)
    {
        if ($pagination) {
            $datas = $this->baseBuilder()->paginate(200);
        } else {
            $datas = $this->baseBuilder()->get();
        }
        dd($this->getReportView());
        return ['datas' => $datas, 'view' => $this->getReportView()];
    }

    public function pdfExportBySnappy()
    {
        $pdf = SnappyPdf::loadView($this->getPdfView(), $this->returnViewData());

        $pdf->setOption('page-size', 'A4'); // A3, A4, A5, Legal, Letter, Tabloid
        $pdf->setOption('orientation', 'Landscape'); // Landscape or Portrait
        $pdf->setOption('header-center', '[page]/[toPage]'); //header-right='[page]/[toPage]'
        $pdf->setOption('footer-left', '[page]/[toPage]'); //header-right='[page]/[toPage]'
        $pdf->setOption('footer-center', 'Company Name'); //header-right='[page]/[toPage]'
        $pdf->setOption('footer-right', now()->format('d-m-Y')); //header-right='[page]/[toPage]'

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'document.pdf');
    }

    public function pdfExportByMpdf()
    {
        $pdf = LaravelMpdf::loadView($this->getPdfView(), $this->returnViewData(), [], [
            'format' => 'A4',
            'autoScriptToLang' => false,
            'autoLangToFont' => false,
            'autoVietnamese' => false,
            'autoArabic' => false
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream('document.pdf');
        }, 'document.pdf');
    }

    public function getHeaderRepeat()
    {
        return true;
    }

    public function render()
    {
        return view('wire-reports::reports', $this->returnViewData(true));
    }
}
