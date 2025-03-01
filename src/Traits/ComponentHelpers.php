<?php
namespace Rishadblack\WireReports\Traits;

use Illuminate\Support\Str;
use Livewire\Features\SupportConsoleCommands\Commands\ComponentParser;

trait ComponentHelpers
{
    protected $report_view;
    protected $button_view;
    protected $pdf_view;
    protected $excel_view;
    protected $filter_view;
    protected $filter_extended_view;
    protected $file_name;
    protected $file_title;
    protected $pagination         = 10;
    protected $pagination_options = [10, 25, 50, 100, 250];
    protected $paper_size;
    protected $orientation;
    protected $default_sort_field;
    protected $default_sort_direction;
    protected $hide_loader;

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

        $fullClassName = get_class($this);
        $namespaceParts = explode('\\', $fullClassName);
        $reportIndex = array_search('Reports', $namespaceParts);

        if ($reportIndex !== false) {
            // Extract everything after 'Reports'
            $subNamespaceParts = array_slice($namespaceParts, $reportIndex);
            $subNamespace = implode('.', $subNamespaceParts);

            $subNamespace = collect(explode('.', $subNamespace))
                ->map(fn($part) => Str::kebab($part))
                ->implode('.');

            $moduleName = $namespaceParts[1] ?? null; // Assuming namespace is Modules\ModuleName\Reports strtolower(config('modules-livewire.namespace'))
            if ($moduleName && is_dir(base_path(config('modules.namespace') . "/{$moduleName}/"))) {
                return strtolower("{$moduleName}::" . (config('modules-livewire.namespace')) . '.' . str_replace('/', '.', $subNamespace));
            }

            // Default Livewire parser
            $parser = new ComponentParser(
                config('livewire.class_namespace'),
                config('livewire.view_path'),
                $subNamespace
            );

            return str_replace('.', '/', $parser->viewName());
        }

        throw new \Exception("Reports namespace not found in class: {$fullClassName}");
    }

    public function setButtonView(string $buttonView)
    {
        $this->button_view = $buttonView;
        return $this;
    }

    public function getButtonView(): string | null
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
        return $this->pdf_view ?? $this->getReportView();
    }

    public function setExcelView(string $excelView)
    {
        $this->excel_view = $excelView;
        return $this;
    }

    public function getExcelView(): string
    {
        return $this->excel_view ?? $this->getReportView();
    }

    public function setFilterView(string $filterView)
    {
        $this->filter_view = $filterView;
        return $this;
    }

    public function getFilterView(): string
    {
        return $this->filter_view ?? 'wire-reports::filters.default';
    }

    public function setFilterExtendedView(string $filterExtendedView)
    {
        $this->filter_extended_view = $filterExtendedView;
        return $this;
    }

    public function getFilterExtendedView(): string
    {
        return $this->filter_extended_view;
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
        if ($this->per_page) {
            return $this->per_page;
        }

        return $this->pagination;
    }

    public function setPaginationOptions(array $pagination_options)
    {
        $this->pagination_options = $pagination_options;
        return $this;
    }

    public function getPaginationOptions(): array
    {

        return $this->pagination_options;
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

    public function getFilter(string $filterName): string | bool
    {
        return isset($this->filters[$filterName]) ? $this->filters[$filterName] : false;
    }

    public function setDefaultSort(string $field, string $direction = 'asc')
    {
        $this->default_sort_field = $field;
        $this->default_sort_direction = $direction;
        return $this;
    }

    public function getDefaultSortField(): array
    {
        return [$this->default_sort_field, $this->default_sort_direction];
    }

    public function hideLoader()
    {
        $this->hide_loader = true;
        return $this;
    }

    public function isHideLoader(): bool
    {
        return $this->hide_loader ?? false;
    }
}