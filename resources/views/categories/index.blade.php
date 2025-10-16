@extends('layouts.app')

@section('header', 'Categories Management')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-gray-800">Data Kategori</h3>
        <button onclick="openCreateModal()" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition shadow-md">
            + Tambah Kategori
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="categoriesTable" class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-blue-50 to-cyan-50">
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Kategori</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Deskripsi</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Form -->
<div id="categoryModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4">
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4 rounded-t-2xl">
            <h3 id="modalTitle" class="text-xl font-bold text-white">Tambah Kategori</h3>
        </div>
        <form id="categoryForm" class="p-6 space-y-4">
            <input type="hidden" id="categoryId">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" id="nama_kategori" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
    table = $('#categoriesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("categories.data") }}',
        columns: [
            { data: 'nama_kategori', name: 'nama_kategori' },
            { data: 'deskripsi', name: 'deskripsi' },
            { data: 'status', name: 'status', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

function openCreateModal() {
    document.getElementById('modalTitle').innerText = 'Tambah Kategori';
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryId').value = '';
    document.getElementById('is_active').checked = true;
    document.getElementById('categoryModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('categoryModal').classList.add('hidden');
}

function editCategory(id) {
    fetch(`/categories/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').innerText = 'Edit Kategori';
            document.getElementById('categoryId').value = data.id;
            document.getElementById('nama_kategori').value = data.nama_kategori;
            document.getElementById('deskripsi').value = data.deskripsi;
            document.getElementById('is_active').checked = data.is_active;
            document.getElementById('categoryModal').classList.remove('hidden');
        });
}

function deleteCategory(id) {
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        fetch(`/categories/${id}`, {
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

document.getElementById('categoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const id = document.getElementById('categoryId').value;
    const url = id ? `/categories/${id}` : '/categories';
    const method = id ? 'PUT' : 'POST';
    
    const formData = {
        nama_kategori: document.getElementById('nama_kategori').value,
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