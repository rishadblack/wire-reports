<div>
    @if (isset($configure['export']) && !$configure['export'])
        @if (isset($filter))
            {{ $filter }}
        @endif
        @if (isset($button))
            {{ $button }}
        @else
            @foreach ($configure['export_options'] as $option)
                <x-wire-reports::button class="{{ $option['class'] }}" wire:click="export('{{ $option['type'] }}')"
                    wire:target="export('{{ $option['type'] }}')">
                    {{ ucfirst($option['type']) }}
                </x-wire-reports::button>
            @endforeach
            <x-wire-reports::button class="btn-danger" wire:click="filterReset"
                wire:target="filterReset">Reset</x-wire-reports::button>
        @endif
    @endif
    <div class="print-layout">
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
            @if (isset($tfoot))
                <tfoot>
                    {{ $tfoot }}
                </tfoot>
            @endif
        </table>
        @if (isset($footer))
            {{ $footer }}
        @endif
    </div>
</div>
