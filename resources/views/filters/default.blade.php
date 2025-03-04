<div>
    <div wire:ignore.self class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-top" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Filter
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach (config('wire-reports.filters') as $filter)
                            @if ($filter['filter_type'] == 'select')
                                <div class="{{ isset($filter['class']) ? $filter['class'] : 'col-lg-12' }}"
                                    wire:key="filter-select-{{ $filter['name'] }}">
                                    <label for="{{ $filter['name'] }}">{{ $filter['title'] }}</label>
                                    <select wire:model="filters.{{ $filter['name'] }}"
                                        class="form-select form-select-sm">
                                        <option value="">Select {{ $filter['title'] }}</option>
                                        @foreach ($filter['options'] as $optionKey => $optionValue)
                                            <option value="{{ $optionKey }}">{{ $optionValue }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif($filter['filter_type'] == 'text')
                                <div class="{{ isset($filter['class']) ? $filter['class'] : 'col-lg-12' }}"
                                    wire:key="filter-text-{{ $filter['name'] }}">
                                    <label for="{{ $filter['name'] }}">{{ $filter['title'] }}</label>
                                    <input wire:model="filters.{{ $filter['name'] }}" class="form-control"
                                        placeholder="{{ $filter['placeholder'] }}" />
                                </div>
                            @elseif($filter['filter_type'] == 'search_component')
                                <div class="{{ isset($filter['class']) ? $filter['class'] : 'col-lg-12' }}"
                                    wire:key="filter-search-component-{{ $filter['name'] }}">
                                    @livewire(
                                        $filter['search_component'],
                                        [
                                            'wire:model' => 'filters.' . $filter['name'],
                                            'name' => $filter['name'],
                                            'label' => $filter['title'],
                                            'placeholder' => $filter['placeholder'],
                                            'key' => 'filter-' . $filter['name'],
                                        ],
                                        key('filter-' . $filter['name'])
                                    )
                                </div>
                            @endif
                            @includeIf($filter_extended_view)
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <x-wire-reports::button class="btn-primary" data-bs-dismiss="modal" wire:click="filterUpdate">Set
                    </x-wire-reports::button>
                </div>
            </div>
        </div>
    </div>
</div>
