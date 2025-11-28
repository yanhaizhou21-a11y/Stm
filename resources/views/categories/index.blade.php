@extends('layouts.app')

@section('header', 'Categories Management')

@section('content')
<x-page-header>
    <x-slot name="header">Categories Management</x-slot>
    <x-slot name="description">Manage inventory categories</x-slot>
    <x-slot name="action">
        <x-btn variant="primary" onclick="openCreateModal()">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Category
        </x-btn>
    </x-slot>

    <div class="overflow-x-auto">
        <table id="categoriesTable" class="w-full">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</x-page-header>

<x-form-modal modal-id="categoryModal" title="Add Category" size="md">
    <form id="categoryForm" class="space-y-4">
        <input type="hidden" id="categoryId">
        
        <x-form.input 
            label="Category Name" 
            name="nama_kategori" 
            id="nama_kategori"
            required 
            placeholder="Enter category name"
        />

        <x-form.textarea 
            label="Description" 
            name="deskripsi" 
            id="deskripsi"
            placeholder="Enter description (optional)"
            rows="3"
        />

        <x-form.checkbox 
            label="Active Status" 
            name="is_active" 
            id="is_active"
            checked
        />

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
            <x-btn variant="secondary" type="button" onclick="closeModal('categoryModal')">
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
let categoryTable;

$(document).ready(function() {
    categoryTable = $('#categoriesTable').DataTable({
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
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryId').value = '';
    document.getElementById('is_active').checked = true;
    document.querySelector('#categoryModal h3').textContent = 'Add Category';
    window.openModal('categoryModal');
}

window.editCategory = async function(id) {
    try {
        const response = await fetch(`/categories/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        if (!response.ok) throw new Error('Failed to load category data');
        
        const data = await response.json();
        
        document.getElementById('categoryId').value = data.id;
        document.getElementById('nama_kategori').value = data.nama_kategori;
        document.getElementById('deskripsi').value = data.deskripsi || '';
        document.getElementById('is_active').checked = data.is_active;
        
        document.querySelector('#categoryModal h3').textContent = 'Edit Category';
        window.openModal('categoryModal');
    } catch (error) {
        window.toast.error(error.message);
    }
};

window.deleteCategory = async function(id) {
    if (!confirm('Are you sure you want to delete this category?')) return;

    try {
        const response = await fetch(`/categories/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (!response.ok) throw new Error(data.message || 'Failed to delete category');
        
        window.toast.success(data.message || 'Category deleted successfully');
        categoryTable.ajax.reload();
    } catch (error) {
        window.toast.error(error.message);
    }
};

document.getElementById('categoryForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const id = document.getElementById('categoryId').value;
    const url = id ? `/categories/${id}` : '/categories';
    const method = id ? 'PUT' : 'POST';
    
    const formData = {
        nama_kategori: document.getElementById('nama_kategori').value,
        deskripsi: document.getElementById('deskripsi').value,
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
            throw new Error(data.message || 'Failed to save category');
        }
        
        window.toast.success(data.message || 'Category saved successfully');
        window.closeModal('categoryModal');
        categoryTable.ajax.reload();
    } catch (error) {
        window.toast.error(error.message);
    }
});
</script>
@endpush