@extends('layouts.app')

@section('header', 'Inventory Management')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-gray-800">Data Inventaris</h3>
        <button onclick="openCreateModal()" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition shadow-md">
            + Tambah Inventaris
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="inventoriesTable" class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-blue-50 to-cyan-50">
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kode Barang</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Barang</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Lokasi</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aktif</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Form -->
<div id="inventoryModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4 rounded-t-2xl">
            <h3 id="modalTitle" class="text-xl font-bold text-white">Tambah Inventaris</h3>
        </div>
        <form id="inventoryForm" class="p-6 space-y-4">
            <input type="hidden" id="inventoryId">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Barang</label>
                    <input type="text" id="kode_barang" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Barang</label>
                    <input type="text" id="nama_barang" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select id="kategori_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Status</option>
                        <option value="Baik">Baik</option>
                        <option value="Rusak">Rusak</option>
                        <option value="Diperbaiki">Diperbaiki</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Barang</label>
                <input type="text" id="lokasi_barang" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea id="deskripsi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="is_active" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Status Aktif</label>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button type="button" onclick="closeModal()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition shadow-md">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let table;

$(document).ready(function() {
    table = $('#inventoriesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("inventories.data") }}',
        columns: [
            { data: 'kode_barang', name: 'kode_barang' },
            { data: 'nama_barang', name: 'nama_barang' },
            { data: 'kategori', name: 'kategori' },
            { data: 'status_badge', name: 'status_badge', orderable: false },
            { data: 'lokasi_barang', name: 'lokasi_barang' },
            { data: 'active_status', name: 'active_status', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

function openCreateModal() {
    document.getElementById('modalTitle').innerText = 'Tambah Inventaris';
    document.getElementById('inventoryForm').reset();
    document.getElementById('inventoryId').value = '';
    document.getElementById('is_active').checked = true;
    document.getElementById('inventoryModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('inventoryModal').classList.add('hidden');
}

function editInventory(id) {
    fetch(`/inventories/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').innerText = 'Edit Inventaris';
            document.getElementById('inventoryId').value = data.id;
            document.getElementById('kode_barang').value = data.kode_barang;
            document.getElementById('nama_barang').value = data.nama_barang;
            document.getElementById('kategori_id').value = data.kategori_id;
            document.getElementById('status').value = data.status;
            document.getElementById('lokasi_barang').value = data.lokasi_barang;
            document.getElementById('deskripsi').value = data.deskripsi;
            document.getElementById('is_active').checked = data.is_active;
            document.getElementById('inventoryModal').classList.remove('hidden');
        });
}

function deleteInventory(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        fetch(`/inventories/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            table.ajax.reload();
        });
    }
}

document.getElementById('inventoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const id = document.getElementById('inventoryId').value;
    const url = id ? `/inventories/${id}` : '/inventories';
    const method = id ? 'PUT' : 'POST';
    
    const formData = {
        kode_barang: document.getElementById('kode_barang').value,
        nama_barang: document.getElementById('nama_barang').value,
        kategori_id: document.getElementById('kategori_id').value,
        status: document.getElementById('status').value,
        lokasi_barang: document.getElementById('lokasi_barang').value,
        deskripsi: document.getElementById('deskripsi').value,
        is_active: document.getElementById('is_active').checked ? 1 : 0
    };
    
    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        closeModal();
        table.ajax.reload();
    })
    .catch(error => {
        alert('Terjadi kesalahan!');
        console.error(error);
    });
});
</script>
@endpush