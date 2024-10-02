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

    #[Url]
    public $sortField; // Default sort field

    #[Url]
    public $sortDirection; // Default sort direction

    abstract public function builder(): Builder;
    abstract public function configure(): void;
    abstract public function columns(): array;

    // Make filters optional by providing a default empty implementation
    public function filters(): array
    {
        return [];
    }

    public function baseBuilder(): Builder
    {
        $builder = $this->builder(); // Start with the base query.


        // Apply the active filters.
        foreach ($this->filters() as $filter) {
            $filterKey = $filter->key(); // Get the filter's key (column).

            if (!empty($this->filters[$filterKey])) {
                $filter->apply($builder, $this->filters[$filterKey]);
            }
        }

        // Apply sorting if $sortField is defined
        if (!empty($this->sortField) && !empty($this->sortDirection)) {
            $builder->orderBy($this->sortField, $this->sortDirection);
        }

        return $builder;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } elseif ($field) {
            $this->sortField = $field;
            $this->sortDirection = 'asc'; // Reset to ascending when changing the sort field
        }
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


        // Get the filters and convert them to arrays
        $filters = array_map(function ($filter) {
            return $filter->toArray();
        }, $this->filters());

        Config::set('wire-reports.filters', $filters);

        return [
            'datas' => $datas,
            'view' => $this->getReportView(),
            'filter_view' => $this->getFilterView(),
            'filter_extended_view' => $this->wide_view,
        ];
    }

    public function defaultSettings()
    {
        $this->sortField = $this->getDefaultSortField()[0];
        $this->sortDirection = $this->getDefaultSortField()[1];
        $this->filters = [];
    }

    public function filterReset(): void
    {
        $this->reset(['filters', 'sortField', 'sortDirection']);
        $this->defaultSettings();
    }

    public function wideView()
    {
        $this->wide_view == 'yes' ? $this->wide_view = 'no' : $this->wide_view = 'yes';
    }

    public function getHeaderRepeat()
    {
        return true;
    }

    public function mount()
    {
        $this->defaultSettings();
    }

    public function render()
    {
        return view('wire-reports::reports', $this->returnViewData(pagination: true));
    }
}
