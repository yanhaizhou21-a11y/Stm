@extends('layouts.app')

@section('header', 'Returns Management')

@section('content')
<x-page-header>
    <x-slot name="header">Returns Management</x-slot>
    <x-slot name="description">Manage borrowed items returns</x-slot>
    <x-slot name="action">
        <x-btn variant="secondary" onclick="window.location.href='{{ route('laporan.index') }}'">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Generate Report
        </x-btn>
    </x-slot>

    @if($peminjaman->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Item</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Borrower</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Borrow Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Return Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($peminjaman as $item)
                <tr class="hover:bg-slate-50 transition-colors duration-150">
                    <td class="px-4 py-3 text-sm text-slate-900">
                        <span class="font-medium">#{{ $item->id }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-slate-900">{{ $item->barang->nama_barang ?? 'N/A' }}</div>
                        <div class="text-xs text-slate-500">{{ $item->barang->kode_barang ?? '' }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm text-slate-900">{{ $item->peminjam_nama ?? 'N/A' }}</div>
                        <div class="text-xs text-slate-500">{{ ucfirst($item->role_label) }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-900">
                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-900">
                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $isOverdue = \Carbon\Carbon::parse($item->tanggal_kembali)->isPast();
                        @endphp
                        <x-status-badge 
                            variant="{{ $isOverdue ? 'error' : 'warning' }}"
                            text="{{ $isOverdue ? 'Overdue' : 'Borrowed' }}"
                        />
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <button onclick='openReturnModal(@json($item))'
                               class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition text-xs font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                Process Return
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <h3 class="text-lg font-medium text-slate-900 mb-1">No pending returns</h3>
        <p class="text-sm text-slate-600">All borrowed items have been returned</p>
    </div>
    @endif
</x-page-header>

<x-form-modal modal-id="returnModal" title="Process Return">
    <form id="returnForm" class="space-y-4">
        <input type="hidden" id="peminjaman_id" name="peminjaman_id">
        
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Borrowing Details</h4>
            <div class="grid grid-cols-2 gap-2 text-sm">
                <div class="text-gray-500">Item:</div>
                <div class="font-medium text-gray-900" id="detail_item"></div>
                
                <div class="text-gray-500">Borrower:</div>
                <div class="font-medium text-gray-900" id="detail_borrower"></div>
                
                <div class="text-gray-500">Borrow Date:</div>
                <div class="font-medium text-gray-900" id="detail_borrow_date"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="status_barang" class="block text-sm font-medium text-gray-700">Condition Status</label>
                <select id="status_barang" name="status_barang" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="dikembalikan">Good Condition (Dikembalikan)</option>
                    <option value="rusak">Damaged (Rusak)</option>
                    <option value="hilang">Lost (Hilang)</option>
                </select>
            </div>

            <x-form.input 
                label="Return Date" 
                name="tanggal_dikembalikan" 
                id="tanggal_dikembalikan"
                type="datetime-local"
                required 
            />
            
            <x-form.textarea 
                label="Notes" 
                name="catatan" 
                id="catatan"
                placeholder="Optional notes about the return condition..."
                rows="3"
            />
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
            <x-btn variant="secondary" type="button" onclick="closeModal('returnModal')">
                Cancel
            </x-btn>
            <x-btn variant="primary" type="submit">
                Process Return
            </x-btn>
        </div>
    </form>
</x-form-modal>

@endsection

@push('scripts')
<script>
function openReturnModal(item) {
    document.getElementById('returnForm').reset();
    document.getElementById('peminjaman_id').value = item.id;
    
    // Populate details
    document.getElementById('detail_item').textContent = item.barang ? item.barang.nama_barang : '-';
    document.getElementById('detail_borrower').textContent = item.peminjam_nama || '-';
    document.getElementById('detail_borrow_date').textContent = new Date(item.tanggal_pinjam).toLocaleDateString();
    
    // Set current date time
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('tanggal_dikembalikan').value = now.toISOString().slice(0, 16);
    
    window.openModal('returnModal');
}

document.getElementById('returnForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    try {
        const response = await fetch('{{ route("pengembalian.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (response.ok) {
            window.toast.success(result.message || 'Return processed successfully');
            window.closeModal('returnModal');
            window.location.reload(); // Reload to update list
        } else {
            if (response.status === 422) {
                let errorMessage = result.message || 'Validation failed';
                if (result.errors) {
                    const errors = Object.values(result.errors).flat();
                    errorMessage += ':\n' + errors.join('\n');
                }
                throw new Error(errorMessage);
            }
            throw new Error(result.message || 'Failed to process return');
        }
    } catch (error) {
        console.error(error);
        window.toast.error(error.message || 'Failed to process return');
    }
});
</script>
@endpush
