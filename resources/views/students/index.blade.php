@extends('layouts.app')

@section('header', 'Students Management')

@section('content')
<x-page-header>
    <x-slot name="header">Students Management</x-slot>
    <x-slot name="description">Manage students information and profiles</x-slot>
    <x-slot name="action">
        <x-btn variant="primary" onclick="openCreateModal()">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Student
        </x-btn>
    </x-slot>

    <div class="overflow-x-auto">
        <table id="studentsTable" class="w-full">
            <thead>
                <tr>
                    <th>NISN</th>
                    <th>Full Name</th>
                    <th>Class</th>
                    <th>Major</th>
                    <th>Year</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</x-page-header>

<x-form-modal modal-id="studentModal" title="Add Student">
    <form id="studentForm" class="space-y-4">
        <input type="hidden" id="studentId">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form.input 
                label="NISN" 
                name="nisn" 
                id="nisn"
                required 
                placeholder="Enter NISN"
            />
            
            <x-form.input 
                label="Full Name" 
                name="nama_lengkap" 
                id="nama_lengkap"
                required 
                placeholder="Enter full name"
            />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-form.input 
                label="Class" 
                name="kelas" 
                id="kelas"
                required 
                placeholder="e.g., 12"
            />
            
            <x-form.input 
                label="Major" 
                name="jurusan" 
                id="jurusan"
                required 
                placeholder="e.g., Science"
            />
            
            <x-form.input 
                label="Year" 
                name="angkatan" 
                id="angkatan"
                required 
                placeholder="e.g., 2024"
            />
        </div>

        <x-form.input 
            label="Phone Number" 
            name="no_hp" 
            id="no_hp"
            type="tel"
            required 
            placeholder="Enter phone number"
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
            <x-btn variant="secondary" type="button" onclick="closeModal('studentModal')">
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
let studentTable;

$(document).ready(function() {
    studentTable = $('#studentsTable').DataTable({
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
    document.getElementById('studentForm').reset();
    document.getElementById('studentId').value = '';
    document.getElementById('is_active').checked = true;
    document.querySelector('#studentModal h3').textContent = 'Add Student';
    window.openModal('studentModal');
}

window.editStudent = async function(id) {
    try {
        const response = await fetch(`/students/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        if (!response.ok) throw new Error('Failed to load student data');
        
        const data = await response.json();
        
        document.getElementById('studentId').value = data.id;
        document.getElementById('nisn').value = data.nisn;
        document.getElementById('nama_lengkap').value = data.nama_lengkap;
        document.getElementById('kelas').value = data.kelas;
        document.getElementById('jurusan').value = data.jurusan;
        document.getElementById('angkatan').value = data.angkatan;
        document.getElementById('no_hp').value = data.no_hp;
        document.getElementById('alamat').value = data.alamat;
        document.getElementById('is_active').checked = data.is_active;
        
        document.querySelector('#studentModal h3').textContent = 'Edit Student';
        window.openModal('studentModal');
    } catch (error) {
        window.toast.error(error.message);
    }
};

window.deleteStudent = async function(id) {
    if (!confirm('Are you sure you want to delete this student?')) return;

    try {
        const response = await fetch(`/students/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (!response.ok) throw new Error(data.message || 'Failed to delete student');
        
        window.toast.success(data.message || 'Student deleted successfully');
        studentTable.ajax.reload();
    } catch (error) {
        window.toast.error(error.message);
    }
};

document.getElementById('studentForm').addEventListener('submit', async function(e) {
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
                // Handle validation errors
                let errorMessage = data.message || 'Validation failed';
                if (data.errors) {
                    const errors = Object.values(data.errors).flat();
                    errorMessage += ':\n' + errors.join('\n');
                }
                throw new Error(errorMessage);
            }
            throw new Error(data.message || 'Failed to save student');
        }
        
        window.toast.success(data.message || 'Student saved successfully');
        window.closeModal('studentModal');
        studentTable.ajax.reload();
    } catch (error) {
        window.toast.error(error.message);
    }
});
</script>
@endpush