@php
    $user = Auth::user();
@endphp

<header class="sticky top-0 z-20 bg-white/90 backdrop-blur border-b border-slate-200">
    <div class="flex h-16 items-center justify-between px-6">
        <div class="flex items-center gap-3">
            <button type="button" class="lg:hidden rounded-xl border border-slate-200 px-3 py-2 text-slate-600" data-toggle-sidebar>
                <span class="sr-only">Open navigation</span>
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                    <path d="M3 6h14M3 10h14M3 14h14" stroke-width="1.6" stroke-linecap="round" />
                </svg>
            </button>
            <div>
                <p class="text-sm text-slate-500">Welcome back</p>
                <p class="text-base font-semibold text-slate-900">{{ $user->name }}</p>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden md:flex flex-col text-right">
                <span class="text-xs text-slate-400 uppercase tracking-[0.2em]">Today</span>
                <span class="text-sm font-medium text-slate-700">{{ now()->format('d M Y') }}</span>
            </div>
            <div class="h-10 w-10 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-sm font-semibold">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
        </div>
    </div>
</header>

