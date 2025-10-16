@props(['type' => 'submit', 'variant' => 'primary'])

@php
    $classes = match($variant) {
        'primary' => 'w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 transform hover:scale-[1.02] shadow-lg',
        'secondary' => 'w-full px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg border-2 border-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300',
        default => 'w-full px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition-all duration-300'
    };
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>