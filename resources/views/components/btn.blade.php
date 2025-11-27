@props([
    'type' => 'button',
    'variant' => 'primary' // primary, secondary, danger
])

@php
$variants = [
    'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',
    'secondary' => 'bg-slate-200 text-slate-700 hover:bg-slate-300 focus:ring-slate-500',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
];
@endphp

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-2.5 rounded-xl font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2 ' . ($variants[$variant] ?? $variants['primary'])]) }}
>
    {{ $slot }}
</button>
