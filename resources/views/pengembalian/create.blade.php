@extends('layouts.app')

@section('header', 'Proses Pengembalian')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-6xl">
<div class="rounded-xl bg-white border-2 border-gray-400 shadow-sm p-6 space-y-4">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Form Pengembalian</h3>

    <div class="rounded-xl bg-gray-50 p-4 mb-4 border-2 border-gray-300">
        <h4 class="font-semibold text-gray-700 mb-2">Detail Peminjaman</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-600">Barang:</span>
                <span class="font-medium">{{ $peminjaman->barang->nama_barang ?? '-' }}</span>
            </div>
            <div>
                <span class="text-gray-600">Peminjam:</span>
                <span class="font-medium">{{ $peminjaman->peminjam_nama ?? '-' }}</span>
            </div>
            <div>
                <span class="text-gray-600">Tanggal Pinjam:</span>
                <span class="font-medium">{{ $peminjaman->tanggal_pinjam ? $peminjaman->tanggal_pinjam->format('d M Y') : '-' }}</span>
            </div>
            <div>
                <span class="text-gray-600">Tanggal Kembali:</span>
                <span class="font-medium">{{ $peminjaman->tanggal_kembali ? $peminjaman->tanggal_kembali->format('d M Y') : '-' }}</span>
            </div>
        </div>
    </div>

    <x-pengembalian.form
        :peminjaman="$peminjaman"
        form-id="pengembalian-form"
        method="POST"
        action="{{ route('pengembalian.store') }}"
        submit-label="Simpan"
    />
</div>
</div>
@endsection

