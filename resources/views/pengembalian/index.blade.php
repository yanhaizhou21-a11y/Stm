@extends('layouts.app')

@section('header', 'Returns Management')

@section('content')
<x-page-header>
    <x-slot name="header">Returns Management</x-slot>
    <x-slot name="description">Manage borrowed items returns</x-slot>
    <x-slot name="action">
        <x-btn variant="secondary" onclick="window.location.href='{{ route('laporan.index') }}'">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Generate Report
        </x-btn>
    </x-slot>

    @if($peminjaman->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Item</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Borrower</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Borrow Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Return Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($peminjaman as $item)
                <tr class="hover:bg-slate-50 transition-colors duration-150">
                    <td class="px-4 py-3 text-sm text-slate-900">
                        <span class="font-medium">#{{ $item->id }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-slate-900">{{ $item->barang->nama_barang ?? 'N/A' }}</div>
                        <div class="text-xs text-slate-500">{{ $item->barang->kode_barang ?? '' }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm text-slate-900">{{ $item->peminjam->name ?? 'N/A' }}</div>
                        <div class="text-xs text-slate-500">{{ $item->peminjam->email ?? '' }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-900">
                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-900">
                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $isOverdue = \Carbon\Carbon::parse($item->tanggal_kembali)->isPast();
                        @endphp
                        <x-status-badge 
                            variant="{{ $isOverdue ? 'error' : 'warning' }}"
                            text="{{ $isOverdue ? 'Overdue' : 'Borrowed' }}"
                        />
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('pengembalian.create', $item->id) }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition text-xs font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                Process Return
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <h3 class="text-lg font-medium text-slate-900 mb-1">No pending returns</h3>
        <p class="text-sm text-slate-600">All borrowed items have been returned</p>
    </div>
    @endif
</x-page-header>
@endsection
