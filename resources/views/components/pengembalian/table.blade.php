@props(['items' => collect()])

<table id="pengembalian-table" class="w-full border-collapse">
    <thead>
        <tr class="bg-gradient-to-r from-blue-50 to-cyan-50">
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Peminjam</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Nama</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Barang</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Tanggal Pinjam</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($items as $item)
        <tr class="border-b-2 border-gray-300 hover:bg-gray-50">
            <td class="px-4 py-3 text-sm border-2 border-gray-300">
                @php
                    $roleLabel = $item->role_label ?? '';
                    if (str_contains($roleLabel, 'Student')) {
                        $roleLabel = 'Siswa';
                    } elseif (str_contains($roleLabel, 'Teacher')) {
                        $roleLabel = 'Guru';
                    } else {
                        $roleLabel = ucfirst($roleLabel);
                    }
                @endphp
                {{ $roleLabel }}
            </td>
            <td class="px-4 py-3 text-sm border-2 border-gray-300">{{ $item->peminjam_nama ?? '-' }}</td>
            <td class="px-4 py-3 text-sm border-2 border-gray-300">{{ $item->barang->nama_barang ?? '-' }}</td>
            <td class="px-4 py-3 text-sm border-2 border-gray-300">{{ $item->tanggal_pinjam ? $item->tanggal_pinjam->format('d M Y') : '-' }}</td>
            <td class="px-4 py-3 border-2 border-gray-300">
                <a href="{{ route('pengembalian.create', $item->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium border-2 border-blue-800">
                    Proses Pengembalian
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Tidak ada data peminjaman yang belum dikembalikan</td>
        </tr>
        @endforelse
    </tbody>
</table>

