<?php
namespace Rishadblack\WireReports\Traits;

use Maatwebsite\Excel\Facades\Excel;
use Rishadblack\WireReports\Exports\ReportExport;

trait WithExcel
{
    public function excelExportByMaatwebsite($type = 'xlsx')
    {
        $class = new ReportExport();
        $class->setCurrentData($this->returnViewData(export: true, layout_type: 'excel'));

        return Excel::download($class, $this->getFileName() . '.' . $type, \Maatwebsite\Excel\Excel::XLSX);
    }
}