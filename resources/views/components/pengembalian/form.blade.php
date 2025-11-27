@props([
    'peminjaman',
    'action' => route('pengembalian.store'),
    'method' => 'POST',
    'formId' => 'pengembalian-form',
    'submitLabel' => 'Simpan',
    'pengembalian' => null,
])

<form id="{{ $formId }}" method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if (!in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif

    <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

    <div class="rounded-xl bg-gray-50 p-4 sm:p-5 border-2 border-gray-300">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-2">
                <x-input-label for="status_barang" value="Status Barang" />
                <select id="status_barang" name="status_barang" required class="w-full border-2 border-gray-400 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Status --</option>
                    <option value="dikembalikan" {{ old('status_barang', $pengembalian->status_barang ?? '') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="rusak" {{ old('status_barang', $pengembalian->status_barang ?? '') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="hilang" {{ old('status_barang', $pengembalian->status_barang ?? '') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                </select>
                <x-input-error :messages="$errors->get('status_barang')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <x-input-label for="tanggal_dikembalikan" value="Tanggal Dikembalikan" />
                <input id="tanggal_dikembalikan" name="tanggal_dikembalikan" type="datetime-local" required 
                    value="{{ old('tanggal_dikembalikan', $pengembalian ? $pengembalian->tanggal_dikembalikan->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                    class="w-full border-2 border-gray-400 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                <x-input-error :messages="$errors->get('tanggal_dikembalikan')" class="mt-2" />
            </div>

            <div class="space-y-2 lg:col-span-2">
                <x-input-label for="catatan" value="Catatan" />
                <textarea id="catatan" name="catatan" rows="3" placeholder="Catatan pengembalian..." 
                    class="w-full border-2 border-gray-400 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('catatan', $pengembalian->catatan ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:justify-end gap-3">
        <button type="submit" id="submit-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium border-2 border-blue-800">{{ $submitLabel }}</button>
        <a href="{{ route('pengembalian.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-center border-2 border-gray-400">Batal</a>
    </div>
</form>

