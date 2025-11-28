@extends('layouts.app')

@section('header', 'Teachers Management')

@section('content')
<x-page-header>
    <x-slot name="header">Teachers Management</x-slot>
    <x-slot name="description">Manage teachers information and profiles</x-slot>
    <x-slot name="action">
        <x-btn variant="primary" onclick="openCreateModal()">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Teacher
        </x-btn>
    </x-slot>

    <div class="overflow-x-auto">
        <table id="teachersTable" class="w-full">
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>Full Name</th>
                    <th>Position</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</x-page-header>

<!-- Create/Edit Modal -->
<x-form-modal modal-id="teacherModal" title="Add Teacher">
    <form id="teacherForm" class="space-y-4">
        <input type="hidden" id="teacherId">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form.input 
                label="NIP" 
                name="nip" 
                id="nip"
                required 
                placeholder="Enter NIP"
            />
            
            <x-form.input 
                label="Full Name" 
                name="nama_lengkap" 
                id="nama_lengkap"
                required 
                placeholder="Enter full name"
            />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form.input 
                label="Position" 
                name="jabatan" 
                id="jabatan"
                required 
                placeholder="Enter position"
            />
            
            <x-form.input 
                label="Phone Number" 
                name="no_hp" 
                id="no_hp"
                type="tel"
                required 
                placeholder="Enter phone number"
            />
        </div>

        <x-form.input 
            label="Email" 
            name="email" 
            id="email"
            type="email"
            required 
            placeholder="Enter email address"
        />

        <x-form.textarea 
            label="Address" 
            name="alamat" 
            id="alamat"
            required 
            placeholder="Enter address"
            rows="3"
        />

        <x-form.checkbox 
            label="Active Status" 
            name="is_active" 
            id="is_active"
            checked
        />

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
            <x-btn variant="secondary" type="button" onclick="closeModal('teacherModal')">
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
let teacherTable;

$(document).ready(function() {
    teacherTable = $('#teachersTable').DataTable({
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
    document.getElementById('teacherForm').reset();
    document.getElementById('teacherId').value = '';
    document.getElementById('is_active').checked = true;
    document.querySelector('#teacherModal h3').textContent = 'Add Teacher';
    window.openModal('teacherModal');
}

window.editTeacher = async function(id) {
    try {
        const response = await fetch(`/teachers/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        if (!response.ok) throw new Error('Failed to load teacher data');
        
        const data = await response.json();
        
        document.getElementById('teacherId').value = data.id;
        document.getElementById('nip').value = data.nip;
        document.getElementById('nama_lengkap').value = data.nama_lengkap;
        document.getElementById('jabatan').value = data.jabatan;
        document.getElementById('no_hp').value = data.no_hp;
        document.getElementById('email').value = data.email;
        document.getElementById('alamat').value = data.alamat;
        document.getElementById('is_active').checked = data.is_active;
        
        document.querySelector('#teacherModal h3').textContent = 'Edit Teacher';
        window.openModal('teacherModal');
    } catch (error) {
        window.toast.error(error.message);
    }
};

window.deleteTeacher = async function(id) {
    if (!confirm('Are you sure you want to delete this teacher?')) return;

    try {
        const response = await fetch(`/teachers/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (!response.ok) throw new Error(data.message || 'Failed to delete teacher');
        
        window.toast.success(data.message || 'Teacher deleted successfully');
        teacherTable.ajax.reload();
    } catch (error) {
        window.toast.error(error.message);
    }
};

document.getElementById('teacherForm').addEventListener('submit', async function(e) {
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
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            if (response.status === 422) {
                let errorMessage = data.message || 'Validation failed';
                if (data.errors) {
                    const errors = Object.values(data.errors).flat();
                    errorMessage += ':\n' + errors.join('\n');
                }
                throw new Error(errorMessage);
            }
            throw new Error(data.message || 'Failed to save teacher');
        }
        
        window.toast.success(data.message || 'Teacher saved successfully');
        window.closeModal('teacherModal');
        teacherTable.ajax.reload();
    } catch (error) {
        window.toast.error(error.message);
    }
});
</script>
@endpush