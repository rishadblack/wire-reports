<?php

namespace Rishadblack\WireReports\Traits;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Rishadblack\WireReports\Exports\ReportExport;

trait WithExcel
{
    public function excelExportByMaatwebsite($type = 'xlsx')
    {
        $class = new ReportExport();
        $class->setCurrentView($this->getExcelView());
        $class->setCurrentData($this->returnViewData(export:true, export_type:'excel'));

        return Excel::download($class, $this->getFileName().'.'.$type, \Maatwebsite\Excel\Excel::XLSX);
    }
}
