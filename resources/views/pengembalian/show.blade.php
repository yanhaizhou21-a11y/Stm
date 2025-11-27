@extends('layouts.app')

@section('header', 'Detail Pengembalian')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-6xl">
<div class="rounded-xl bg-white border-2 border-gray-400 shadow-sm p-6 space-y-4">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Detail Pengembalian</h3>

    <div class="rounded-xl bg-gray-50 p-4 mb-4 border-2 border-gray-300">
        <h4 class="font-semibold text-gray-700 mb-4">Informasi Peminjaman</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-600">Barang:</span>
                <span class="font-medium ml-2">{{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}</span>
            </div>
            <div>
                <span class="text-gray-600">Peminjam:</span>
                <span class="font-medium ml-2">{{ $pengembalian->peminjaman->peminjam_nama ?? '-' }}</span>
            </div>
            <div>
                <span class="text-gray-600">Tanggal Pinjam:</span>
                <span class="font-medium ml-2">{{ $pengembalian->peminjaman->tanggal_pinjam ? $pengembalian->peminjaman->tanggal_pinjam->format('d M Y') : '-' }}</span>
            </div>
            <div>
                <span class="text-gray-600">Status:</span>
                <span class="font-medium ml-2">
                    @php
                        $colors = [
                            'dikembalikan' => 'bg-green-100 text-green-800',
                            'rusak' => 'bg-red-100 text-red-800',
                            'hilang' => 'bg-gray-100 text-gray-800',
                        ];
                        $color = $colors[$pengembalian->status_barang] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2 py-1 text-xs rounded-full {{ $color }}">{{ ucfirst($pengembalian->status_barang) }}</span>
                </span>
            </div>
        </div>
    </div>

    <div class="rounded-xl bg-gray-50 p-4 mb-4 border-2 border-gray-300">
        <h4 class="font-semibold text-gray-700 mb-4">Informasi Pengembalian</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-600">Tanggal Dikembalikan:</span>
                <span class="font-medium ml-2">{{ $pengembalian->tanggal_dikembalikan->format('d M Y H:i') }}</span>
            </div>
            <div>
                <span class="text-gray-600">Status Barang:</span>
                <span class="font-medium ml-2">
                    @php
                        $colors = [
                            'dikembalikan' => 'bg-green-100 text-green-800',
                            'rusak' => 'bg-red-100 text-red-800',
                            'hilang' => 'bg-gray-100 text-gray-800',
                        ];
                        $color = $colors[$pengembalian->status_barang] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2 py-1 text-xs rounded-full {{ $color }}">{{ ucfirst($pengembalian->status_barang) }}</span>
                </span>
            </div>
            @if($pengembalian->catatan)
            <div class="md:col-span-2">
                <span class="text-gray-600">Catatan:</span>
                <p class="font-medium mt-1">{{ $pengembalian->catatan }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('pengembalian.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
            Kembali
        </a>
        <a href="{{ route('pengembalian.edit', $pengembalian->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Edit
        </a>
    </div>
</div>
</div>
@endsection

