@extends('layouts.app')

@section('header', 'Manajemen Peminjaman')

@section('content')
<div class="space-y-6">
    @if (session('success'))
        <x-alert type="success">
            {{ session('success') }}
        </x-alert>
    @endif

    <div class="grid grid-cols-1 gap-6">
        <div class="xl:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-6 h-full flex flex-col">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Daftar Peminjaman</h3>
                        <p class="text-sm text-gray-500">Pantau histori peminjaman barang secara real-time.</p>
                    </div>
                    <div>
                        <x-button type="button" variant="primary" data-open-create>Tambah Peminjaman</x-button>
                    </div>
                </div>

                <x-peminjaman.table :items="$peminjaman" />
            </div>
        </div>
    </div>

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
@endsection

@include('components.peminjaman.scripts')