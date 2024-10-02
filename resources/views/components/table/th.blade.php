@use('Rishadblack\WireReports\Helpers\WireReportHelper')
@php
    $columnName = $attributes->get('column');
    $columnData = WireReportHelper::getColumn($columnName);
@endphp
@if (!$columnData['is_hidden'])
    @if (!in_array(config('wire-reports.configure.layout_type'), $columnData['hide_in']))
        <th {{ $attributes }}>
            @if (!config('wire-reports.configure.export') && $columnData['sortable'])
                @php
                    $isSorted = $this->sortField === $columnName;
                    $isAsc = $isSorted && $this->sortDirection === 'asc';
                @endphp
                <a href="#" wire:click.prevent="sortBy('{{ $columnName }}')">
                    @if ($slot->isNotEmpty())
                        {{ $slot }}
                    @else
                        {{ $columnData['title'] ?? '' }}
                    @endif
                    @if ($isSorted)
                        @if ($isAsc)
                            <span>&uarr;</span>
                        @else
                            <span>&darr;</span>
                        @endif
                    @endif
                </a>
            @else
                @if ($slot->isNotEmpty())
                    {{ $slot }}
                @else
                    {{ $columnData['title'] ?? '' }}
                @endif
            @endif
        </th>
    @endif
@endif
