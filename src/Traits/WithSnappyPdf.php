<?php

namespace Rishadblack\WireReports\Traits;

use Illuminate\Support\Str;
use Barryvdh\Snappy\Facades\SnappyPdf;

trait WithSnappyPdf
{
    public function pdfExportBySnappy()
    {
        $pdf = SnappyPdf::loadView($this->getPdfView(), $this->returnViewData(export:true));

        $pdf->setOption('page-size', $this->getPaperSize()); // A3, A4, A5, Legal, Letter, Tabloid
        $pdf->setOption('orientation', $this->getOrientation()); // Landscape or Portrait

        $pdf->setOption('header-left', '[page]/[toPage]'); //header-right='[page]/[toPage]'
        $pdf->setOption('header-center', '[page]/[toPage]'); //header-right='[page]/[toPage]'
        $pdf->setOption('header-right', '[page]/[toPage]'); //header-right='[page]/[toPage]'

        $pdf->setOption('footer-left', '[page]/[toPage]'); //header-right='[page]/[toPage]'
        $pdf->setOption('footer-center', 'Company Name'); //header-right='[page]/[toPage]'
        $pdf->setOption('footer-right', now()->format('d-m-Y')); //header-right='[page]/[toPage]'

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $this->getFileName().'.pdf');
    }
}
