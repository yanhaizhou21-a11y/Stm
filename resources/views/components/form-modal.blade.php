@props([
    'modalId',
    'title' => 'Modal',
    'size' => 'md' // sm, md, lg, xl
])

@php
$sizeClasses = [
    'sm' => 'max-w-md',
    'md' => 'max-w-2xl',
    'lg' => 'max-w-4xl',
    'xl' => 'max-w-6xl',
];
@endphp

<div id="{{ $modalId }}" class="modal-overlay hidden fixed inset-0 bg-slate-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="modal-content bg-white rounded-2xl shadow-soft-xl w-full {{ $sizeClasses[$size] }} max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-slate-200 px-6 py-4 rounded-t-2xl flex items-center justify-between">
            <h3 class="text-xl font-semibold text-slate-900">{{ $title }}</h3>
            <button type="button" data-close-modal="{{ $modalId }}" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>
