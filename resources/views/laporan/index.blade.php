@extends('layouts.app')

@section('header', 'Laporan Peminjaman')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-6xl">
<div class="rounded-xl bg-white border-2 border-gray-400 shadow-sm p-6 space-y-4">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Filter Laporan</h3>

    <form method="POST" action="{{ route('laporan.filter') }}" id="filter-form" class="rounded-xl bg-gray-50 p-4 mb-6 border-2 border-gray-400">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-input-label for="tanggal_mulai" value="Tanggal Mulai" />
                <input id="tanggal_mulai" name="tanggal_mulai" type="date" required 
                    value="{{ request('tanggal_mulai', old('tanggal_mulai')) }}"
                    class="w-full border-2 border-gray-400 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="tanggal_selesai" value="Tanggal Selesai" />
                <input id="tanggal_selesai" name="tanggal_selesai" type="date" required 
                    value="{{ request('tanggal_selesai', old('tanggal_selesai')) }}"
                    class="w-full border-2 border-gray-400 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex-1 font-medium">
                    Tampilkan Data
                </button>
                <button type="button" id="lihat-laporan-btn" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition font-medium border-2 border-green-800 hidden">
                    Lihat Laporan
                </button>
            </div>
        </div>
    </form>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalMulai = document.getElementById('tanggal_mulai');
            const tanggalSelesai = document.getElementById('tanggal_selesai');
            const lihatLaporanBtn = document.getElementById('lihat-laporan-btn');
            
            function checkDates() {
                if (tanggalMulai.value && tanggalSelesai.value) {
                    lihatLaporanBtn.classList.remove('hidden');
                    lihatLaporanBtn.onclick = function() {
                        document.getElementById('filter-form').submit();
                    };
                } else {
                    lihatLaporanBtn.classList.add('hidden');
                }
            }
            
            tanggalMulai.addEventListener('change', checkDates);
            tanggalSelesai.addEventListener('change', checkDates);
            checkDates(); // Check on page load
        });
    </script>

    @if(isset($laporan) && $laporan->isNotEmpty())
        <div class="mb-4 flex gap-3">
            <a href="{{ route('laporan.excel', ['tanggal_mulai' => $tanggal_mulai ?? '', 'tanggal_selesai' => $tanggal_selesai ?? '']) }}" 
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition font-medium border-2 border-green-700">
                Export Excel
            </a>
            <a href="{{ route('laporan.pdf', ['tanggal_mulai' => $tanggal_mulai ?? '', 'tanggal_selesai' => $tanggal_selesai ?? '']) }}" 
                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-medium border-2 border-red-700">
                Export PDF
            </a>
        </div>

        <div class="overflow-x-auto">
            <x-laporan.table :items="$laporan" />
        </div>
    @elseif(isset($laporan))
        <div class="text-center py-8 text-gray-500 border-2 border-gray-300 rounded-lg bg-gray-50">
            <p class="font-medium">Tidak ada data laporan untuk periode yang dipilih.</p>
            <p class="text-sm mt-2">Periode: {{ $tanggal_mulai ?? '' }} s/d {{ $tanggal_selesai ?? '' }}</p>
        </div>
    @else
    <div class="text-center py-8 text-gray-500 border-2 border-gray-300 rounded-lg bg-gray-50">
        <p class="font-medium">Silakan pilih tanggal untuk menampilkan laporan.</p>
    </div>
    @endif
</div>
</div>
@endsection

