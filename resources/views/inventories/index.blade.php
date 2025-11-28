@extends('layouts.app')

@section('header', 'Inventory Management')

@section('content')
<x-page-header>
    <x-slot name="header">Inventory Management</x-slot>
    <x-slot name="description">Manage school inventory items</x-slot>
    <x-slot name="action">
        <x-btn variant="primary" onclick="openCreateModal()">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Item
        </x-btn>
    </x-slot>

    <div class="overflow-x-auto">
        <table id="inventoriesTable" class="w-full">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</x-page-header>

<x-form-modal modal-id="inventoryModal" title="Add Inventory Item">
    <form id="inventoryForm" class="space-y-4">
        <input type="hidden" id="inventoryId">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form.input 
                label="Item Code" 
                name="kode_barang" 
                id="kode_barang"
                required 
                placeholder="Enter item code"
            />
            
            <x-form.input 
                label="Item Name" 
                name="nama_barang" 
                id="nama_barang"
                required 
                placeholder="Enter item name"
            />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label for="kategori_id" class="block text-sm font-medium text-slate-700">
                    Category <span class="text-red-500">*</span>
                </label>
                <select
                    id="kategori_id"
                    name="kategori_id"
                    required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-slate-900"
                >
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="space-y-2">
                <label for="status" class="block text-sm font-medium text-slate-700">
                    Item Status <span class="text-red-500">*</span>
                </label>
                <select
                    id="status"
                    name="status"
                    required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-slate-900"
                >
                    <option value="">Select Status</option>
                    <option value="Baik">Good</option>
                    <option value="Rusak">Damaged</option>
                    <option value="Diperbaiki">Under Repair</option>
                </select>
            </div>
        </div>

        <x-form.input 
            label="Item Location" 
            name="lokasi_barang" 
            id="lokasi_barang"
            required 
            placeholder="Enter item location"
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
            <x-btn variant="secondary" type="button" onclick="closeModal('inventoryModal')">
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
let inventoryTable;

$(document).ready(function() {
    inventoryTable = $('#inventoriesTable').DataTable({
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
    document.getElementById('inventoryForm').reset();
    document.getElementById('inventoryId').value = '';
    document.getElementById('is_active').checked = true;
    document.querySelector('#inventoryModal h3').textContent = 'Add Inventory Item';
    window.openModal('inventoryModal');
}

window.editInventory = async function(id) {
    try {
        const response = await fetch(`/inventories/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        if (!response.ok) throw new Error('Failed to load inventory data');
        
        const data = await response.json();
        
        document.getElementById('inventoryId').value = data.id;
        document.getElementById('kode_barang').value = data.kode_barang;
        document.getElementById('nama_barang').value = data.nama_barang;
        document.getElementById('kategori_id').value = data.kategori_id;
        document.getElementById('status').value = data.status;
        document.getElementById('lokasi_barang').value = data.lokasi_barang;
        document.getElementById('deskripsi').value = data.deskripsi || '';
        document.getElementById('is_active').checked = data.is_active;
        
        document.querySelector('#inventoryModal h3').textContent = 'Edit Inventory Item';
        window.openModal('inventoryModal');
    } catch (error) {
        window.toast.error(error.message);
    }
};

window.deleteInventory = async function(id) {
    if (!confirm('Are you sure you want to delete this item?')) return;

    try {
        const response = await fetch(`/inventories/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (!response.ok) throw new Error(data.message || 'Failed to delete item');
        
        window.toast.success(data.message || 'Item deleted successfully');
        inventoryTable.ajax.reload();
    } catch (error) {
        window.toast.error(error.message);
    }
};

document.getElementById('inventoryForm').addEventListener('submit', async function(e) {
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
            throw new Error(data.message || 'Failed to save item');
        }
        
        window.toast.success(data.message || 'Item saved successfully');
        window.closeModal('inventoryModal');
        inventoryTable.ajax.reload();
    } catch (error) {
        window.toast.error(error.message);
    }
});
</script>
@endpush