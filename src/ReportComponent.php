<?php

namespace Rishadblack\WireReports;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Rishadblack\WireReports\Traits\WithExcel;
use Rishadblack\WireReports\Traits\WithMpdfPdf;
use Rishadblack\WireReports\Traits\WithSnappyPdf;
use Rishadblack\WireReports\Traits\ComponentHelpers;

abstract class ReportComponent extends Component
{
    use WithPagination;
    use WithMpdfPdf;
    use WithSnappyPdf;
    use WithExcel;
    use ComponentHelpers;

    #[Url]
    public $filters = [];

    abstract public function builder(): Builder;
    abstract public function configure(): void;

    public function baseBuilder(): Builder
    {
        return $this->builder();
    }

    public function export(string $type)
    {
        if ($type == 'pdf') {
            return $this->exportPdf();
        } elseif ($type == 'xlsx' || $type == 'csv') {
            return $this->exportExcel($type);
        }
    }

    public function exportPdf()
    {
        try {
            if (config('wire-reports.pdf_export_by') == 'mpdf') {
                return $this->pdfExportByMpdf();
            } elseif (config('wire-reports.pdf_export_by') == 'snappy') {
                return $this->pdfExportBySnappy();
            }
        } catch (\Exception $e) {
            dd('PDF generation error: ' . $e->getMessage());
        }
    }

    public function exportExcel($type)
    {
        try {
            return $this->excelExportByMaatwebsite($type);
        } catch (\Exception $e) {
            dd('Excel generation error: ' . $e->getMessage());
        }
    }

    public function returnViewData(bool|int $pagination = false, bool $export = false, string $export_type = 'pdf')
    {
        $this->configure();

        if ($pagination) {
            $datas = $this->baseBuilder()->paginate($this->getPagination());
        } else {
            $datas = $this->baseBuilder()->get();
        }

        return [
            'datas' => $datas,
            'view' => $this->getReportView(),
            'configure' => [
                'export' => $export,
                'export_type' => $export_type, // pdf or excel
                'export_options' => config('wire-reports.export_options'),
                'title' => $this->getFileTitle(),
                'button' => $this->getButtonView(),
            ]

        ];
    }

    public function filterReset(): void
    {
        $this->reset('filters');
    }

    public function getHeaderRepeat()
    {
        return true;
    }

    public function render()
    {
        return view('wire-reports::reports', $this->returnViewData(pagination:true));
    }
}
