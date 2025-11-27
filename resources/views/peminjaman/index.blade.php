@extends('layouts.app')

@section('header', 'Manajemen Peminjaman')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-6xl">
<div class="rounded-xl bg-white border-2 border-gray-400 shadow-sm p-6 space-y-4">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold text-gray-800">Data Peminjaman</h3>
        <button type="button" data-open-create class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah Peminjaman
        </button>
    </div>

    <div class="overflow-x-auto">
        <x-peminjaman.table :items="$peminjaman" />
    </div>
</div>

<!-- Modals -->
<x-peminjaman.modal modal-id="create-peminjaman-modal" title="Form Peminjaman">
    <x-peminjaman.form
        :inventories="$inventories"
        :students="$students"
        :teachers="$teachers"
        form-id="create-peminjaman-form"
        method="POST"
        action="{{ route('peminjaman.store') }}"
        submit-label="Simpan"
        field-prefix="create-"
    />
</x-peminjaman.modal>

<x-peminjaman.modal modal-id="edit-peminjaman-modal" title="Edit Peminjaman">
    <x-peminjaman.form
        :inventories="$inventories"
        :students="$students"
        :teachers="$teachers"
        form-id="edit-peminjaman-form"
        method="PUT"
        action="{{ route('peminjaman.update', '__ID__') }}"
        data-action-template="{{ route('peminjaman.update', '__ID__') }}"
        submit-label="Perbarui"
        field-prefix="edit-"
    />
</x-peminjaman.modal>
</div>
</div>
@endsection

@include('components.peminjaman.scripts')