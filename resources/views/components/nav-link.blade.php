{{-- resources/views/components/nav-link.blade.php --}}
@props(['active' => false])

@php
$classes = $active
    ? 'block w-full text-left px-4 py-2 rounded-lg bg-blue-50 text-blue-700 font-medium'
    : 'block w-full text-left px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
