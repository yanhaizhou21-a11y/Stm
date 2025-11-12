@extends('layouts.app')

@section('header', 'Manajemen Peminjaman')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-gray-800">Data Peminjaman</h3>
        <button type="button" data-open-create class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition shadow-md">
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
@endsection

@include('components.peminjaman.scripts')