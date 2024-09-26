<?php

namespace Rishadblack\WireReports\Traits;

use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;

trait WithMpdfPdf
{
    public function pdfExportByMpdf()
    {
        $pdf = LaravelMpdf::loadView($this->getPdfView(), $this->returnViewData(export: true, layout_type: 'pdf'), [], [
            'format' => $this->getPaperSize(),
            'orientation' => ($this->getOrientation() == 'landscape' ? 'L' : 'P'),
            'setAutoTopMargin' => 'stretch', // Ensure that header is not overwritten
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
            <td width="33%" align="center">Company Name</td>
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
