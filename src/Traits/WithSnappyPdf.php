<?php
namespace Rishadblack\WireReports\Traits;

use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Config;

trait WithSnappyPdf
{
    public function pdfExportBySnappy()
    {
        Config::set('snappy.pdf', [
            'binary' => config('wire-reports.snappy.binary'),
            'timeout' => config('wire-reports.snappy.timeout'),
            'options' => config('wire-reports.snappy.options'),
        ]);

        $pdf = SnappyPdf::loadView('wire-reports::reports', $this->returnViewData(export: true, layout_type: 'pdf'));

        $pdf->setOption('page-size', $this->getPaperSize());     // A3, A4, A5, Legal, Letter, Tabloid
        $pdf->setOption('orientation', $this->getOrientation()); // Landscape or Portrait

        if (config('wire-reports.pdf_header.html_view')) {
            $pdf->setOption('header-html', view(config('wire-reports.pdf_header.html_view'))->render());
        }

        $this->setHeaderFooterOption($pdf, 'header', 'left');
        $this->setHeaderFooterOption($pdf, 'header', 'center');
        $this->setHeaderFooterOption($pdf, 'header', 'right');
        $this->setHeaderFooterOption($pdf, 'footer', 'left');
        $this->setHeaderFooterOption($pdf, 'footer', 'center');
        $this->setHeaderFooterOption($pdf, 'footer', 'right');

        $pdf->setOption('margin-bottom', config('wire-reports.snappy.margin-bottom'));
        $pdf->setOption('margin-top', config('wire-reports.snappy.margin-top'));
        $pdf->setOption('margin-left', config('wire-reports.snappy.margin-left'));
        $pdf->setOption('margin-right', config('wire-reports.snappy.margin-right'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $this->getFileName() . '.pdf');
    }

    public function setHeaderFooterOption($pdf, string $type, string $position)
    {
        $configValue = config("wire-reports.pdf_{$type}.{$position}");

        if ($configValue) {
            $value = '';

            switch ($configValue) {
                case 'current_page':
                    $value = '[page]';
                    break;
                case 'total_page':
                    $value = '[toPage]';
                    break;
                case 'current_page_and_total_page':
                    $value = '[page]/[toPage]';
                    break;
                case 'date':
                    $value = now()->format('d-m-Y');
                    break;
                case 'time':
                    $value = now()->format('h:i:s A');
                    break;
                case 'date_and_time':
                    $value = now()->format('d-m-Y h:i:s A');
                    break;
                default:
                    $value = $configValue;
                    break;
            }

            $pdf->setOption("{$type}-{$position}", $value);
        }
    }

}