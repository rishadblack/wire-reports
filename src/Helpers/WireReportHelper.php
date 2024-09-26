<?php

namespace Rishadblack\WireReports\Helpers;

class WireReportHelper
{
    public static function getColumn(string $column_name = null)
    {

        if ($column_name) {
            $columns = collect(config('wire-reports.columns'));
            $filteredColumns = $columns->filter(fn ($column) => $column->toArray()['name'] === $column_name)->first();
            if ($filteredColumns) {
                return $filteredColumns->toArray();
            }
        }

        return [];

    }
}
