@props(['modalId' => 'peminjaman-modal', 'title' => 'Kelola Peminjaman'])

<div id="{{ $modalId }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-[100] flex items-center justify-center overflow-y-auto no-scrollbar">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4">
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4 rounded-t-2xl flex items-center justify-between">
            <h3 class="text-xl font-bold text-white" data-modal-title>{{ $title }}</h3>
            <button type="button" class="text-white/90 hover:text-white transition text-2xl leading-none" data-close-modal>&times;</button>
        </div>
        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
    </div>

@push('styles')
<style>
/* Hide overlay scrollbar (make it transparent) */
.no-scrollbar { scrollbar-width: none; }
.no-scrollbar::-webkit-scrollbar { width: 0; height: 0; background: transparent; }
</style>
@endpush

