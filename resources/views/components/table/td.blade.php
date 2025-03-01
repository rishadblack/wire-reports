@props(['column', 'name'])
@if (isset($column['name']) && $name == $column['name'])
    <td {{ $attributes }}>
        {{ $slot }}
    </td>
@elseif(!isset($column['name']) && $slot->isNotEmpty())
    <td {{ $attributes }}>{{ $slot }}</td>
@endif
