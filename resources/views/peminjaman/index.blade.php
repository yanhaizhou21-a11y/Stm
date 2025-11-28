@extends('layouts.app')

@section('header', 'Peminjaman Management')

@section('content')
<x-page-header>
    <x-slot name="header">Peminjaman Management</x-slot>
    <x-slot name="description">Manage borrowing records</x-slot>
    <x-slot name="action">
        <x-btn variant="primary" onclick="openCreateModal()">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Peminjaman
        </x-btn>
    </x-slot>

    <div class="overflow-x-auto">
        <table id="peminjamanTable" class="w-full">
            <thead>
                <tr>
                    <th>Borrower</th>
                    <th>Role</th>
                    <th>Item</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</x-page-header>

<x-form-modal modal-id="peminjamanModal" title="Add Peminjaman">
    <form id="peminjamanForm" class="space-y-4">
        <input type="hidden" id="peminjamanId">
        <input type="hidden" id="peminjam_id" name="peminjam_id">
        <input type="hidden" id="barang_id" name="barang_id">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role Peminjam</label>
                <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required onchange="resetPeminjamInput()">
                    <option value="student">Siswa</option>
                    <option value="teacher">Guru</option>
                </select>
            </div>

            <div>
                <label id="label_peminjam_code" for="peminjam_code" class="block text-sm font-medium text-gray-700">NISN</label>
                <div class="flex gap-2 mt-1">
                    <input type="text" id="peminjam_code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter ID" required>
                    <button type="button" onclick="checkPeminjam()" class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">Check</button>
                </div>
                <p id="peminjam_name" class="mt-1 text-sm font-medium text-green-600 hidden"></p>
                <p id="peminjam_error" class="mt-1 text-sm text-red-600 hidden"></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="barang_code" class="block text-sm font-medium text-gray-700">Kode Barang</label>
                <div class="flex gap-2 mt-1">
                    <input type="text" id="barang_code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter Item Code" required>
                    <button type="button" onclick="checkBarang()" class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">Check</button>
                </div>
                <p id="barang_name" class="mt-1 text-sm font-medium text-green-600 hidden"></p>
                <p id="barang_error" class="mt-1 text-sm text-red-600 hidden"></p>
            </div>

            <x-form.input 
                label="Tanggal Pinjam" 
                name="tanggal_pinjam" 
                id="tanggal_pinjam"
                type="date"
                required 
            />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form.input 
                label="Tanggal Kembali (Rencana)" 
                name="tanggal_kembali" 
                id="tanggal_kembali"
                type="date"
            />
            
            <x-form.input 
                label="Keterangan" 
                name="keterangan" 
                id="keterangan"
                placeholder="Optional"
            />
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
            <x-btn variant="secondary" type="button" onclick="closeModal('peminjamanModal')">
                Cancel
            </x-btn>
            <x-btn variant="primary" type="submit">
                Save
            </x-btn>
        </div>
    </form>
</x-form-modal>

@endsection

@push('scripts')
<script>
let peminjamanTable;

$(document).ready(function() {
    peminjamanTable = $('#peminjamanTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("peminjaman.data") }}',
        columns: [
            { data: 'peminjam', name: 'peminjam' },
            { data: 'role', name: 'role' },
            { data: 'barang', name: 'barang' },
            { data: 'tanggal_pinjam', name: 'tanggal_pinjam' },
            { data: 'tanggal_kembali', name: 'tanggal_kembali' },
            { data: 'status', name: 'status', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

function resetPeminjamInput() {
    const role = document.getElementById('role').value;
    const label = document.getElementById('label_peminjam_code');
    label.textContent = role === 'student' ? 'NISN' : 'NIP';
    
    document.getElementById('peminjam_code').value = '';
    document.getElementById('peminjam_id').value = '';
    document.getElementById('peminjam_name').textContent = '';
    document.getElementById('peminjam_name').classList.add('hidden');
    document.getElementById('peminjam_error').classList.add('hidden');
}

async function checkPeminjam() {
    const role = document.getElementById('role').value;
    const code = document.getElementById('peminjam_code').value;
    const errorEl = document.getElementById('peminjam_error');
    const nameEl = document.getElementById('peminjam_name');
    const idInput = document.getElementById('peminjam_id');

    if (!code) return;

    try {
        const response = await fetch(`{{ route('peminjaman.check') }}?role=${role}&code=${code}`);
        const data = await response.json();

        if (response.ok) {
            idInput.value = data.id;
            nameEl.textContent = data.nama;
            nameEl.classList.remove('hidden');
            errorEl.classList.add('hidden');
        } else {
            throw new Error(data.error || 'Data not found');
        }
    } catch (error) {
        idInput.value = '';
        nameEl.classList.add('hidden');
        errorEl.textContent = error.message;
        errorEl.classList.remove('hidden');
    }
}

async function checkBarang() {
    const code = document.getElementById('barang_code').value;
    const errorEl = document.getElementById('barang_error');
    const nameEl = document.getElementById('barang_name');
    const idInput = document.getElementById('barang_id');

    if (!code) return;

    try {
        const response = await fetch(`{{ route('inventories.check') }}?code=${code}`);
        const data = await response.json();

        if (response.ok) {
            idInput.value = data.id;
            nameEl.textContent = data.nama_barang;
            nameEl.classList.remove('hidden');
            errorEl.classList.add('hidden');
        } else {
            throw new Error(data.error || 'Item not found');
        }
    } catch (error) {
        idInput.value = '';
        nameEl.classList.add('hidden');
        errorEl.textContent = error.message;
        errorEl.classList.remove('hidden');
    }
}

function openCreateModal() {
    document.getElementById('peminjamanForm').reset();
    document.getElementById('peminjamanId').value = '';
    document.getElementById('peminjam_id').value = '';
    document.getElementById('barang_id').value = '';
    resetPeminjamInput();
    
    // Clear validation messages
    document.getElementById('peminjam_name').classList.add('hidden');
    document.getElementById('peminjam_error').classList.add('hidden');
    document.getElementById('barang_name').classList.add('hidden');
    document.getElementById('barang_error').classList.add('hidden');

    document.querySelector('#peminjamanModal h3').textContent = 'Add Peminjaman';
    window.openModal('peminjamanModal');
}

window.editPeminjaman = async function(id) {
    try {
        const response = await fetch(`/peminjaman/${id}/edit`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        if (!response.ok) throw new Error('Failed to load peminjaman data');
        
        const result = await response.json();
        const data = result.data;
        
        document.getElementById('peminjamanId').value = data.id;
        document.getElementById('role').value = data.role;
        resetPeminjamInput(); // Updates label
        
        // Pre-fill hidden IDs
        document.getElementById('peminjam_id').value = data.peminjam_id;
        document.getElementById('barang_id').value = data.barang_id;
        
        document.getElementById('tanggal_pinjam').value = data.tanggal_pinjam;
        document.getElementById('tanggal_kembali').value = data.tanggal_kembali;
        document.getElementById('keterangan').value = data.keterangan;
        
        document.querySelector('#peminjamanModal h3').textContent = 'Edit Peminjaman';
        window.openModal('peminjamanModal');
    } catch (error) {
        console.error(error);
        window.toast.error(error.message);
    }
};

window.deletePeminjaman = async function(id) {
    if (!confirm('Are you sure you want to delete this record?')) return;

    try {
        const response = await fetch(`/peminjaman/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (!response.ok) throw new Error(data.message || 'Failed to delete record');
        
        window.toast.success(data.message || 'Record deleted successfully');
        peminjamanTable.ajax.reload();
    } catch (error) {
        window.toast.error(error.message);
    }
};

document.getElementById('peminjamanForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Validate that IDs are set
    if (!document.getElementById('peminjam_id').value) {
        window.toast.error('Please check and validate Peminjam ID');
        return;
    }
    if (!document.getElementById('barang_id').value) {
        window.toast.error('Please check and validate Barang Code');
        return;
    }

    const id = document.getElementById('peminjamanId').value;
    const url = id ? `/peminjaman/${id}` : '/peminjaman';
    const method = id ? 'PUT' : 'POST';
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            if (response.status === 422) {
                let errorMessage = result.message || 'Validation failed';
                if (result.errors) {
                    const errors = Object.values(result.errors).flat();
                    errorMessage += ':\n' + errors.join('\n');
                }
                throw new Error(errorMessage);
            }
            throw new Error(result.message || 'Failed to save');
        }
        
        window.toast.success('Record saved successfully');
        window.closeModal('peminjamanModal');
        peminjamanTable.ajax.reload();
    } catch (error) {
        console.error(error);
        window.toast.error(error.message || 'Failed to save record');
    }
});
</script>
@endpush