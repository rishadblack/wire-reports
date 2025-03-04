<?php
namespace Rishadblack\WireReports\Traits;

use Illuminate\Support\Facades\Config;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;

trait WithMpdfPdf
{
    public function pdfExportByMpdf()
    {
        Config::set('pdf.title', config('wire-reports.default_download_file_name'));
        Config::set('pdf.mode', 'utf-8');
        Config::set('pdf.margin_left', config('wire-reports.mpdf.margin_left'));
        Config::set('pdf.margin_right', config('wire-reports.mpdf.margin_right'));
        Config::set('pdf.margin_top', config('wire-reports.mpdf.margin_top'));
        Config::set('pdf.margin_bottom', config('wire-reports.mpdf.margin_bottom'));
        Config::set('pdf.default_font', config('wire-reports.mpdf.default_font'));
        Config::set('pdf.font_path', config('wire-reports.mpdf.font_path'));
        Config::set('pdf.font_data', config('wire-reports.mpdf.font_data'));
        Config::set('pdf.default_font_size', config('wire-reports.mpdf.default_font_size'));
        Config::set('pdf.auto_language_detection', config('wire-reports.mpdf.auto_language_detection'));

        $pdf = LaravelMpdf::loadView('wire-reports::reports', $this->returnViewData(export: true, layout_type: 'pdf'), [], [
            'format' => $this->getPaperSize(),
            'orientation' => ($this->getOrientation() == 'landscape' ? 'L' : 'P'),
            'setAutoTopMargin' => 'stretch',    // Ensure that header is not overwritten
            'setAutoBottomMargin' => 'stretch', // Ensure that footer is not overwritten
        ]);

        // $pdf->getMpdf()->SetDisplayMode('fullpage');

        // Set headers (left, center, right)
        // $pdf->getMpdf()->SetHeader('{PAGENO}/{nbpg}||{PAGENO}/{nbpg}|{PAGENO}/{nbpg}');

        // Set footers (left, center, right)
        // $pdf->getMpdf()->SetFooter('{PAGENO}/{nbpg}|Company Name|' . now()->format('d-m-Y'));

        // Set headers (applies to all pages)
        $pdf->getMpdf()->SetHTMLHeader('
    <table width="100%">
        <tr>
            <td width="33%">{PAGENO}/{nbpg}</td>
            <td width="33%" align="center">{PAGENO}/{nbpg}</td>
            <td width="33%" align="right">{PAGENO}/{nbpg}</td>
        </tr>
    </table>
');

        // Set footers (applies to all pages)
        $pdf->getMpdf()->SetHTMLFooter('
    <table width="100%">
        <tr>
            <td width="33%">{PAGENO}/{nbpg}</td>
            <td width="33%" align="center"></td>
            <td width="33%" align="right">' . now()->format('d-m-Y') . '</td>
        </tr>
    </table>
');

        // Ensure headers and footers are applied throughout all pages
        // $pdf->getMpdf()->AddPage();

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream($this->getFileName() . '.pdf');
        }, $this->getFileName() . '.pdf');
    }
}