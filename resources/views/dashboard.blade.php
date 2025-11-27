@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        @php
            $metrics = [
                ['label' => 'Total Teachers', 'value' => $stats['teachers'], 'description' => 'Active teachers', '  icon' => 'M10 9a3 3 0 100-6 3 3 0 000 6zm-6 9a6 6 0 1112 0'],
                ['label' => 'Total Students', 'value' => $stats['students'], 'description' => 'Active students', 'icon' => 'M6 8a3 3 0 11-6 0 3 3 0 016 0zm8 0a3 3 0 11-6 0 3 3 0 016 0z'],
                ['label' => 'Inventory Items', 'value' => $stats['inventories'], 'description' => 'Total items', 'icon' => 'M4 6h12l-1 9H5z'],
                ['label' => 'Categories', 'value' => $stats['categories'], 'description' => 'Item categories', 'icon' => 'M3 5h14v4H3zm0 6h14v4H3z'],
            ];
        @endphp

        @foreach ($metrics as $metric)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-soft hover:shadow-soft-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600">{{ $metric['label'] }}</p>
                        <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $metric['value'] }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $metric['description'] }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                <path d="{{ $metric['icon'] }}" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Welcome Section -->
    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-soft">
        <div class="space-y-6">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900">Welcome to School Management System</h2>
                <p class="text-slate-600 leading-relaxed mt-2">
                    Manage teachers, students, inventories, and more through a unified interface. Use the quick links below to jump straight into each module.
                </p>
            </div>
            
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                @foreach ([
                    ['label' => 'Manage Teachers', 'desc' => 'Add and update teacher data', 'route' => 'teachers.index', 'icon' => 'M10 9a3 3 0 100-6 3 3 0 000 6zm-6 9a6 6 0 1112 0'],
                    ['label' => 'Manage Students', 'desc' => 'Track student information', 'route' => 'students.index', 'icon' => 'M6 8a3 3 0 11-6 0 3 3 0 016 0zm8 0a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['label' => 'Inventory Control', 'desc' => 'Monitor school assets', 'route' => 'inventories.index', 'icon' => 'M4 6h12l-1 9H5z M8 6V4a2 2 0 114 0v2'],
                ] as $link)
                    <a href="{{ route($link['route']) }}" class="group rounded-2xl border border-slate-200 px-6 py-5 transition-all duration-200 hover:border-indigo-200 hover:bg-indigo-50 hover:shadow-soft-md">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 group-hover:bg-indigo-100 transition-colors">
                                    <svg class="w-5 h-5 text-slate-600 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                        <path d="{{ $link['icon'] }}" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-slate-900">{{ $link['label'] }}</p>
                                <p class="text-xs text-slate-600 mt-1">{{ $link['desc'] }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection