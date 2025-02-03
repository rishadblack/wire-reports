<div>
    <div class="row">
        @foreach (context('wire-reports.filters', []) as $filter)
            @if ($filter['filter_type'] == 'select')
                <div class="{{ isset($filter['class']) ? $filter['class'] : 'col-lg-4' }}">
                    <label for="{{ $filter['name'] }}"
                        style="font-weight: bold; margin-bottom: .1rem;">{{ $filter['title'] }}</label>
                    <select wire:model.live.debounce.{{ $filter['response_time'] }}ms="filters.{{ $filter['name'] }}"
                        class="form-select form-select-sm">
                        <option value="">Select {{ $filter['title'] }}</option>
                        @foreach ($filter['options'] as $optionKey => $optionValue)
                            <option value="{{ $optionKey }}">{{ $optionValue }}</option>
                        @endforeach
                    </select>
                </div>
            @elseif($filter['filter_type'] == 'text')
                <div class="{{ isset($filter['class']) ? $filter['class'] : 'col-lg-4' }}">
                    <label for="{{ $filter['name'] }}"
                        style="font-weight: bold; margin-bottom: .1rem;">{{ $filter['title'] }}</label>
                    <input wire:model.live.debounce.{{ $filter['response_time'] }}ms="filters.{{ $filter['name'] }}"
                        class="form-control" placeholder="{{ $filter['placeholder'] }}" />
                </div>
            @endif
            @includeIf($filter_extended_view)
        @endforeach
    </div>

</div>
