@props([
    'variant' => 'success', // success, error, warning, info
    'text' => ''
])

@php
$variants = [
    'success' => 'bg-green-100 text-green-800 border-green-200',
    'error' => 'bg-red-100 text-red-800 border-red-200',
    'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
    'info' => 'bg-blue-100 text-blue-800 border-blue-200',
    'active' => 'bg-green-100 text-green-800 border-green-200',
    'inactive' => 'bg-slate-100 text-slate-800 border-slate-200',
];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ' . ($variants[$variant] ?? $variants['info'])]) }}>
    {{ $text ?: $slot }}
</span>
