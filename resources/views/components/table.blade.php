@props(['filter', 'button', 'header', 'logo', 'subheader', 'thead', 'tbody', 'tfoot', 'footer'])
<div>
    @if (!config('wire-reports.configure.export'))
        @if (isset($filter))
            {{ $filter }}
        @endif
        @if (isset($button))
            {{ $button }}
        @else
            @if (config('wire-reports.show_export_button'))
                @foreach (config('wire-reports.export_options') as $option)
                    <x-wire-reports::button class="{{ $option['class'] }}" wire:click="export('{{ $option['type'] }}')"
                        wire:target="export('{{ $option['type'] }}')">
                        {{ ucfirst($option['type']) }}
                    </x-wire-reports::button>
                @endforeach
            @endif
        @endif
        @if (config('wire-reports.show_reset_button'))
            <x-wire-reports::button class="btn-danger" wire:click="filterReset"
                wire:target="filterReset">Reset</x-wire-reports::button>
        @endif
        @if (config('wire-reports.show_wide_view_button'))
            <x-wire-reports::button class="btn-info" wire:click="wideView"
                wire:target="wideView">{{ config('wire-reports.configure.wide_view') == 'yes' ? 'Print View' : 'Wide View' }}</x-wire-reports::button>
        @endif
    @endif
    <div
        class="print-layout {{ config('wire-reports.configure.wide_view') == 'no' ? 'print-layout-' . config('wire-reports.configure.orientation') : '' }}">
        @if (
            (isset($header) &&
                !in_array(config('wire-reports.configure.layout_type'), explode('|', $header->attributes->get('hide')))) ||
                (isset($logo) &&
                    !in_array(config('wire-reports.configure.layout_type'), explode('|', $logo->attributes->get('hide')))))
            <table {{ $header->attributes->merge(['class' => 'table', 'style' => '']) }}>
                <thead>
                    {{ isset($logo) &&
                    !in_array(config('wire-reports.configure.layout_type'), explode('|', $logo->attributes->get('hide')))
                        ? $logo
                        : '' }}
                    {{ isset($header) &&
                    !in_array(config('wire-reports.configure.layout_type'), explode('|', $header->attributes->get('hide')))
                        ? $header
                        : '' }}
                </thead>
            </table>
        @endif
        <table {{ $attributes->merge(['class' => 'table']) }}>
            @if (
                (isset($thead) &&
                    !in_array(config('wire-reports.configure.layout_type'), explode('|', $thead->attributes->get('hide')))) ||
                    (isset($subheader) &&
                        !in_array(config('wire-reports.configure.layout_type'), explode('|', $subheader->attributes->get('hide')))))
                <thead {{ $thead->attributes->merge(['class' => '', 'style' => '']) }}>
                    {{ isset($subheader) &&
                    !in_array(config('wire-reports.configure.layout_type'), explode('|', $subheader->attributes->get('hide')))
                        ? $subheader
                        : '' }}
                    {{ isset($thead) &&
                    !in_array(config('wire-reports.configure.layout_type'), explode('|', $thead->attributes->get('hide')))
                        ? $thead
                        : '' }}
                </thead>
            @endif
            @if (isset($tbody) &&
                    !in_array(config('wire-reports.configure.layout_type'), explode('|', $tbody->attributes->get('hide'))))
                <tbody {{ $tbody->attributes->merge(['class' => '', 'style' => '']) }}>
                    {{ $tbody }}
                </tbody>
            @else
                <tbody>
                    {{ $slot }}
                </tbody>
            @endif
            @if (isset($tfoot) &&
                    !in_array(config('wire-reports.configure.layout_type'), explode('|', $tfoot->attributes->get('hide'))))
                <tfoot {{ $tfoot->attributes->merge(['class' => '', 'style' => '']) }}>
                    {{ $tfoot }}
                </tfoot>
            @endif
        </table>
        @if (isset($footer) &&
                !in_array(config('wire-reports.configure.layout_type'), explode('|', $footer->attributes->get('hide'))))
            {{ $footer }}
        @endif
    </div>
</div>
