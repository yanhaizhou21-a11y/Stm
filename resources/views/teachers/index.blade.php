@extends('layouts.app')

@section('header', 'Teachers Management')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-gray-800">Data Guru</h3>
        <button onclick="openCreateModal()" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition shadow-md">
            + Tambah Guru
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="teachersTable" class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-blue-50 to-cyan-50">
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">NIP</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Lengkap</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jabatan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No HP</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Form -->
<div id="teacherModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4 rounded-t-2xl">
            <h3 id="modalTitle" class="text-xl font-bold text-white">Tambah Guru</h3>
        </div>
        <form id="teacherForm" class="p-6 space-y-4">
            <input type="hidden" id="teacherId">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                    <input type="text" id="nip" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                    <input type="text" id="jabatan" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                    <input type="text" id="no_hp" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <textarea id="alamat" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
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
    table = $('#teachersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("teachers.data") }}',
        columns: [
            { data: 'nip', name: 'nip' },
            { data: 'nama_lengkap', name: 'nama_lengkap' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'email', name: 'email' },
            { data: 'status', name: 'status', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

function openCreateModal() {
    document.getElementById('modalTitle').innerText = 'Tambah Guru';
    document.getElementById('teacherForm').reset();
    document.getElementById('teacherId').value = '';
    document.getElementById('is_active').checked = true;
    document.getElementById('teacherModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('teacherModal').classList.add('hidden');
}

function editTeacher(id) {
    fetch(`/teachers/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').innerText = 'Edit Guru';
            document.getElementById('teacherId').value = data.id;
            document.getElementById('nip').value = data.nip;
            document.getElementById('nama_lengkap').value = data.nama_lengkap;
            document.getElementById('jabatan').value = data.jabatan;
            document.getElementById('no_hp').value = data.no_hp;
            document.getElementById('email').value = data.email;
            document.getElementById('alamat').value = data.alamat;
            document.getElementById('is_active').checked = data.is_active;
            document.getElementById('teacherModal').classList.remove('hidden');
        });
}

function deleteTeacher(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        fetch(`/teachers/${id}`, {
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

document.getElementById('teacherForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const id = document.getElementById('teacherId').value;
    const url = id ? `/teachers/${id}` : '/teachers';
    const method = id ? 'PUT' : 'POST';
    
    const formData = {
        nip: document.getElementById('nip').value,
        nama_lengkap: document.getElementById('nama_lengkap').value,
        jabatan: document.getElementById('jabatan').value,
        no_hp: document.getElementById('no_hp').value,
        email: document.getElementById('email').value,
        alamat: document.getElementById('alamat').value,
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