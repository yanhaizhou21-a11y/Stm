@props([
    'as' => 'div',
    'padding' => 'p-6',
    'spacing' => 'space-y-4',
])

@php
    $classes = "bg-white border border-slate-200 shadow-sm rounded-2xl {$padding}";
    $tag = $as;
@endphp

<{{ $tag }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</{{ $tag }}>

