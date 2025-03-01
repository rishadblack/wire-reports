@props(['column', 'name'])
@if (isset($column['name']) && $name == $column['name'])
    <th {{ $attributes }}>
        {{ $slot }}
    </th>
@elseif(!isset($column['name']) && $slot->isNotEmpty())
    <th {{ $attributes }}>{{ $slot }}</th>
@endif
