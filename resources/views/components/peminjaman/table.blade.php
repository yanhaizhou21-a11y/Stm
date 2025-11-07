@props(['items' => collect()])

<div class="overflow-x-auto rounded-2xl border border-blue-100 shadow-lg">
    <table id="peminjaman-table" class="min-w-full divide-y divide-blue-100">
        <thead class="bg-gradient-to-r from-blue-50 to-cyan-50">
            <tr>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">#</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Peminjam</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Peran</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Barang</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Tanggal Pinjam</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Tanggal Kembali</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Keterangan</th>
                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-blue-700 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-blue-50"></tbody>
    </table>
</div>

