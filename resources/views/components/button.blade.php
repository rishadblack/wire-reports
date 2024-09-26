<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn waves-effect waves-light']) }}
    @isset($attributes['wire:target']) wire:loading.attr="disabled" @endisset>
    @isset($attributes['wire:target'])
        @isset($attributes['icon'])
            <i wire:loading.remove wire:target="{{ $attributes['wire:target'] }}" class="{{ $attributes['icon'] }}"></i>
        @endisset
        <span wire:loading.remove wire:target="{{ $attributes['wire:target'] }}">{{ $slot }}</span>
        <div wire:loading wire:target="{{ $attributes['wire:target'] }}"><i
                class="align-middle bx bx-loader bx-spin font-size-16"></i> Loading</div>
    @else
        @isset($attributes['icon'])
            <i class="{{ $attributes['icon'] }}"></i>
        @endisset
        {{ $slot }}
    @endisset
</button>
