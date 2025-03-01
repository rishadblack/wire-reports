<?php
namespace Rishadblack\WireReports\Traits;

use Illuminate\Support\Facades\Config;

trait WithExport
{
    use WithExcel;
    use WithMpdfPdf;
    use WithSnappyPdf;

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

}