@props(['items' => collect()])

<table class="w-full border-collapse">
    <thead>
        <tr class="bg-gradient-to-r from-blue-50 to-cyan-50">
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Peminjam</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Barang</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Tanggal Pinjam</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Tanggal Kembali</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Status</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Catatan</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-2 border-gray-400">Tanggal Pengembalian</th>
        </tr>
    </thead>
    <tbody>
        @forelse($items as $item)
        <tr class="border-b-2 border-gray-300 hover:bg-gray-50">
            <td class="px-4 py-3 text-sm border-2 border-gray-300">
                @php
                    $roleLabel = $item->role_label ?? $item->role ?? '';
                    if (str_contains($roleLabel, 'Student') || str_contains($roleLabel, 'student')) {
                        $roleLabel = 'Siswa';
                    } elseif (str_contains($roleLabel, 'Teacher') || str_contains($roleLabel, 'teacher')) {
                        $roleLabel = 'Guru';
                    } else {
                        $roleLabel = ucfirst($roleLabel);
                    }
                @endphp
                {{ $roleLabel }} - {{ $item->peminjam_nama ?? '-' }}
            </td>
            <td class="px-4 py-3 text-sm border-2 border-gray-300">{{ $item->barang ?? '-' }}</td>
            <td class="px-4 py-3 text-sm border-2 border-gray-300">{{ $item->tanggal_pinjam ? date('d M Y', strtotime($item->tanggal_pinjam)) : '-' }}</td>
            <td class="px-4 py-3 text-sm border-2 border-gray-300">{{ $item->tanggal_kembali ? date('d M Y', strtotime($item->tanggal_kembali)) : '-' }}</td>
            <td class="px-4 py-3 text-sm border-2 border-gray-300">
                @php
                    $colors = [
                        'dipinjam' => 'bg-blue-100 text-blue-800',
                        'dikembalikan' => 'bg-green-100 text-green-800',
                        'rusak' => 'bg-red-100 text-red-800',
                        'hilang' => 'bg-gray-100 text-gray-800',
                    ];
                    $color = $colors[$item->status ?? ''] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="px-2 py-1 text-xs rounded-full {{ $color }} border border-gray-400">{{ ucfirst($item->status ?? '-') }}</span>
            </td>
            <td class="px-4 py-3 text-sm border-2 border-gray-300">{{ $item->catatan ?? '-' }}</td>
            <td class="px-4 py-3 text-sm border-2 border-gray-300">{{ $item->tanggal_dikembalikan ? date('d M Y H:i', strtotime($item->tanggal_dikembalikan)) : '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="px-4 py-8 text-center text-gray-500 border-2 border-gray-300">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>

