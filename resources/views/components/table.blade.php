@if (isset($configure['export']) && !$configure['export'])
    @if (isset($filter))
        {{ $filter }}
    @endif
    @if (isset($button))
        {{ $button }}
    @else
        <x-wire-reports::button wire:click="export('pdf')" wire:target="export('pdf')">PDF</x-wire-reports::button>
        <x-wire-reports::button class="btn-info" wire:click="export('xlsx')"
            wire:target="export('xlsx')">Excel</x-wire-reports::button>
        <x-wire-reports::button class="btn-warning" wire:click="export('csv')"
            wire:target="export('csv')">CSV</x-wire-reports::button>
        <x-wire-reports::button class="btn-danger" wire:click="filterReset"
            wire:target="filterReset">Reset</x-wire-reports::button>
    @endif
@endif
@if (isset($header) || isset($logo))
    <table class="table">
        <thead>
            {{ isset($logo) && isset($configure['export_type']) && $configure['export_type'] !== 'excel' ? $logo : '' }}
            {{ isset($header) ? $header : '' }}
        </thead>
    </table>
@endif
<table class="table table-border">
    @if (isset($thead) || isset($subheader))
        <thead>
            {{ isset($subheader) ? $subheader : '' }}
            {{ isset($thead) ? $thead : '' }}
        </thead>
    @endif
    @if (isset($tbody))
        <tbody>
            {{ $tbody }}
        </tbody>
    @else
        <tbody>
            {{ $slot }}
        </tbody>
    @endif
    @if (isset($footer))
        <tfoot>
            {{ $footer }}
        </tfoot>
    @endif
</table>
