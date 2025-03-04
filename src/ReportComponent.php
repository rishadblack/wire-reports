<?php
namespace Rishadblack\WireReports;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Rishadblack\WireReports\Traits\ComponentHelpers;
use Rishadblack\WireReports\Traits\WithExport;
use Rishadblack\WireReports\Traits\WithQueryBuilder;

abstract class ReportComponent extends Component
{
    use WithPagination;
    use WithExport;
    use WithQueryBuilder;
    use ComponentHelpers;

    #[Url]
    public $wide_view = 'yes';

    #[Url]
    public $filters = [];

    #[Url]
    public $sortField; // Default sort field

    #[Url]
    public $sortDirection; // Default sort direction

    #[Url]
    public $per_page;

    #[Url( as :'q')]
    public $search;

    abstract public function builder(): Builder;
    abstract public function configure(): void;
    abstract public function columns(): array;

    #[Computed]
    public function extraData()
    {
        return $this->additionalQuery();
    }

    // Make filters optional by providing a default empty implementation
    public function additionalQuery(): array
    {
        return [];
    }

    public function additionalData(): array
    {
        return [];
    }

    // Make filters optional by providing a default empty implementation
    public function filters(): array
    {
        return [];
    }

    public function search(Builder $builder, $search): Builder
    {
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
            'paper_size' => $this->getPaperSize(),
            'pagination' => $this->getPagination(),
            'pagination_options' => $this->getPaginationOptions(),
            'hide_loader' => $this->isHideLoader(),
        ]);

        Config::set('wire-reports.filters', array_map(fn($filters) => $filters->toArray(), $this->filters()));

        return [
            'datas' => $datas,
            'columns' => array_map(fn($column) => $column->toArray(), $this->columns()),
            'view' => $this->getReportView(),
            'filter_view' => $this->getFilterView(),
            'filter_extended_view' => $this->wide_view,
            'additional_query' => $this->extraData,
            'additional_data' => $this->additionalData(),
        ];
    }

    public function defaultSettings()
    {
        $this->sortField = $this->getDefaultSortField()[0];
        $this->sortDirection = $this->getDefaultSortField()[1];
    }

    public function filterReset(): void
    {
        $this->reset(['filters', 'search', 'sortField', 'sortDirection']);
        $this->defaultSettings();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function filterUpdate()
    {
        $this->resetPage();
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