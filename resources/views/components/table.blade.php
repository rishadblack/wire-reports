@props(['filter', 'button', 'header', 'logo', 'subheader', 'thead', 'tbody', 'tfoot', 'footer'])
<div>
    @if (!config('wire-reports.configure.export'))
        <!-- Bootstrap Modal -->
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3 ">
                        <div class="form-inline">
                            <select wire:model.live="per_page" class="form-select form-select d-inline">
                                <option value="">Default</option>
                                @foreach (config('wire-reports.configure.pagination_options') as $paginationOptions)
                                    <option value="{{ $paginationOptions }}">Per Page {{ $paginationOptions }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <input wire:model.live.debounce.500ms="search" class="form-control" placeholder="Search" />
                    </div>
                </div>
            </div>
            <div class="col-md-6" align="right">
                @if (isset($filter))
                    {{ $filter }}
                @endif
                @if (isset($button))
                    {{ $button }}
                @else
                    @if (config('wire-reports.show_export_button'))
                        @foreach (config('wire-reports.export_options') as $option)
                            <x-wire-reports::button class="{{ $option['class'] }}"
                                wire:click="export('{{ $option['type'] }}')"
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalId">
                    Filter
                </button>
                @if (config('wire-reports.show_wide_view_button'))
                    <x-wire-reports::button class="btn-info" wire:click="wideView"
                        wire:target="wideView">{{ config('wire-reports.configure.wide_view') == 'yes' ? 'Print View' : 'Wide View' }}</x-wire-reports::button>
                @endif
            </div>
        </div>
    @endif

    <div
        class="print-layout position-relative {{ config('wire-reports.configure.wide_view') == 'no' ? 'print-layout-' . config('wire-reports.configure.orientation') : '' }}">
        @if (!config('wire-reports.configure.hide_loader') && !config('wire-reports.configure.export'))
            <div wire:loading.class.remove="d-none"
                class="position-absolute top-0 start-0 w-100 h-100 bg-dark d-flex justify-content-center align-items-center d-none"
                style="z-index: 10; opacity: 0.6;">
                <div class="spinner-border text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        @endif


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
