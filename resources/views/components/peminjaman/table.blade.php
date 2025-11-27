@props(['items' => collect()])

<table id="peminjaman-table" class="w-full">
    <thead>
        <tr class="bg-gradient-to-r from-blue-50 to-cyan-50">
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Peminjam</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Barang</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID Barang</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tanggal Pinjam</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tanggal Kembali</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Keterangan</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
        </tr>
    </thead>
</table>

