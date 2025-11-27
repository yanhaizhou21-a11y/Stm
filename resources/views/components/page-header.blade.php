<div {{ $attributes->merge(['class' => 'space-y-6']) }}>
    @if(isset($header))
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">{{ $header }}</h2>
            @if(isset($description))
            <p class="text-sm text-slate-600 mt-1">{{ $description }}</p>
            @endif
        </div>
        @if(isset($action))
        <div>
            {{ $action }}
        </div>
        @endif
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-soft-lg border border-slate-100 overflow-hidden">
        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>
