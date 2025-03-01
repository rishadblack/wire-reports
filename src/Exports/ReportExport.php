<?php
namespace Rishadblack\WireReports\Exports;

// use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as LaravelView;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportExport implements FromView, ShouldAutoSize, WithEvents
{
    public string $currentView;
    public array $currentData = [];

    public function view(): LaravelView
    {
        return View::make('wire-reports::reports', $this->currentData);
    }

    public function setCurrentView($currentView)
    {
        $this->currentView = $currentView;
        return $this;
    }

    public function setCurrentData($currentData)
    {
        $this->currentData = $currentData;
        return $this;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Merge cells for the logo row to span across columns
                // $sheet->mergeCells('A1:C1');

                // Center the image and text in the merged cells
                // $sheet->getStyle('A1:C1')->applyFromArray([
                //     'alignment' => [
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                //         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                //     ],
                // ]);

                // Adjust column widths to help center the content
                // $sheet->getColumnDimension('A')->setWidth(30);
                // $sheet->getColumnDimension('B')->setWidth(30);
                // $sheet->getColumnDimension('C')->setWidth(30);

                // Adjust the row height to fit the logo
                // $sheet->getRowDimension(1)->setRowHeight(90);

                // // Apply styles to other rows if needed (e.g., headers)
                // $sheet->getStyle('A2:C2')->applyFromArray([
                //     'font' => [
                //         'bold' => true,
                //         'size' => 14,
                //     ],
                //     'alignment' => [
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                //     ],
                // ]);
            },
        ];
    }
}