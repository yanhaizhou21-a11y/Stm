@extends('layouts.app')

@section('header', 'Students Management')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-gray-800">Data Siswa</h3>
        <button onclick="openCreateModal()" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition shadow-md">
            + Tambah Siswa
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="studentsTable" class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-blue-50 to-cyan-50">
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">NISN</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Lengkap</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kelas</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jurusan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Angkatan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No HP</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Form -->
<div id="studentModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4 rounded-t-2xl">
            <h3 id="modalTitle" class="text-xl font-bold text-white">Tambah Siswa</h3>
        </div>
        <form id="studentForm" class="p-6 space-y-4">
            <input type="hidden" id="studentId">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NISN</label>
                    <input type="text" id="nisn" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                    <input type="text" id="kelas" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan</label>
                    <input type="text" id="jurusan" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Angkatan</label>
                    <input type="text" id="angkatan" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                <input type="text" id="no_hp" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
    table = $('#studentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("students.data") }}',
        columns: [
            { data: 'nisn', name: 'nisn' },
            { data: 'nama_lengkap', name: 'nama_lengkap' },
            { data: 'kelas', name: 'kelas' },
            { data: 'jurusan', name: 'jurusan' },
            { data: 'angkatan', name: 'angkatan' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'status', name: 'status', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

function openCreateModal() {
    document.getElementById('modalTitle').innerText = 'Tambah Siswa';
    document.getElementById('studentForm').reset();
    document.getElementById('studentId').value = '';
    document.getElementById('is_active').checked = true;
    document.getElementById('studentModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('studentModal').classList.add('hidden');
}

function editStudent(id) {
    fetch(`/students/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').innerText = 'Edit Siswa';
            document.getElementById('studentId').value = data.id;
            document.getElementById('nisn').value = data.nisn;
            document.getElementById('nama_lengkap').value = data.nama_lengkap;
            document.getElementById('kelas').value = data.kelas;
            document.getElementById('jurusan').value = data.jurusan;
            document.getElementById('angkatan').value = data.angkatan;
            document.getElementById('no_hp').value = data.no_hp;
            document.getElementById('alamat').value = data.alamat;
            document.getElementById('is_active').checked = data.is_active;
            document.getElementById('studentModal').classList.remove('hidden');
        });
}

function deleteStudent(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        fetch(`/students/${id}`, {
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

document.getElementById('studentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const id = document.getElementById('studentId').value;
    const url = id ? `/students/${id}` : '/students';
    const method = id ? 'PUT' : 'POST';
    
    const formData = {
        nisn: document.getElementById('nisn').value,
        nama_lengkap: document.getElementById('nama_lengkap').value,
        kelas: document.getElementById('kelas').value,
        jurusan: document.getElementById('jurusan').value,
        angkatan: document.getElementById('angkatan').value,
        no_hp: document.getElementById('no_hp').value,
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