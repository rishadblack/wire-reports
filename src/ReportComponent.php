<?php

namespace Rishadblack\WireReports;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Builder;
use Rishadblack\WireReports\Traits\WithExcel;
use Rishadblack\WireReports\Traits\WithMpdfPdf;
use Rishadblack\WireReports\Traits\WithSnappyPdf;
use Rishadblack\WireReports\Traits\ComponentHelpers;
use Rishadblack\WireReports\Helpers\WireReportHelper;

abstract class ReportComponent extends Component
{
    use WithPagination;
    use WithMpdfPdf;
    use WithSnappyPdf;
    use WithExcel;
    use ComponentHelpers;

    #[Url]
    public $wide_view = 'yes';

    #[Url]
    public $filters = [];

    abstract public function builder(): Builder;
    abstract public function configure(): void;
    abstract public function columns(): array;

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

    public function returnViewData(bool | int $pagination = false, bool $export = false, string $layout_type = 'view')
    {
        $this->configure();

        if ($pagination) {
            $datas = $this->baseBuilder()->paginate($this->getPagination());
        } else {
            $datas = $this->baseBuilder()->get();
        }

        Config::set('wire-reports.configure', [
                'export' => $export,
                'layout_type' => $layout_type,
                'orientation' => $this->getOrientation(),
                'wide_view' => $this->wide_view,
                'title' => $this->getFileTitle(),
                'button' => $this->getButtonView(),
        ]);
        Config::set('wire-reports.columns', $this->columns());

        return [
            'datas' => $datas,
            'view' => $this->getReportView(),
        ];
    }

    public function filterReset(): void
    {
        $this->reset('filters');
    }

    public function wideView()
    {
        $this->wide_view == 'yes' ? $this->wide_view = 'no' : $this->wide_view = 'yes';
    }

    public function getHeaderRepeat()
    {
        return true;
    }

    public function render()
    {
        return view('wire-reports::reports', $this->returnViewData(pagination: true));
    }
}
