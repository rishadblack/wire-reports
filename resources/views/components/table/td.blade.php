@use('Rishadblack\WireReports\Helpers\WireReportHelper')
@php
    $columnName = $attributes->get('column');
    $columnData = WireReportHelper::getColumn($columnName);
@endphp
@if (!$columnData['is_hidden'])
    @if (!in_array(config('wire-reports.configure.layout_type'), $columnData['hide_in']))
        <td {{ $attributes }}>
            {{ $slot }}
        </td>
    @endif
@endif
