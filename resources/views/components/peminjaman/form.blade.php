@props([
    'inventories' => collect(),
    'students' => collect(),
    'teachers' => collect(),
    'action' => route('peminjaman.store'),
    'method' => 'POST',
    'formId' => 'peminjaman-form',
    'submitLabel' => 'Simpan',
    'fieldPrefix' => '',
])

<form id="{{ $formId }}" method="POST" action="{{ $action }}" {{ $attributes->merge(['class' => 'space-y-6']) }}>
    @csrf
    @if (!in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif

    <div class="rounded-xl bg-gray-50/80 p-4 sm:p-5">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-2">
            <x-input-label :for="$fieldPrefix . 'role'" value="Peminjam" />
            <select id="{{ $fieldPrefix }}role" name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300/40" data-role-select>
                <option value="">-- Pilih Jenis Peminjam --</option>
                <option value="student">Siswa</option>
                <option value="teacher">Guru</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label :for="$fieldPrefix . 'peminjam_id'" value="ID Peminjam" />
            <div class="flex gap-2">
                <input id="{{ $fieldPrefix }}peminjam_lookup" type="text" inputmode="numeric" placeholder="Masukkan ID peminjam" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300/40" />
                <x-button type="button" id="{{ $fieldPrefix }}check-peminjam" class="whitespace-nowrap">Cek ID</x-button>
            </div>
            <div id="{{ $fieldPrefix }}peminjam-result" class="text-xs text-gray-500"></div>
            <select id="{{ $fieldPrefix }}peminjam_id" name="peminjam_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300/40 mt-2" data-peminjam-select>
                <option value="">-- Pilih Nama --</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" data-role="student">Siswa - {{ $student->nama_lengkap }}</option>
                @endforeach
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" data-role="teacher">Guru - {{ $teacher->nama_lengkap }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('peminjam_id')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label :for="$fieldPrefix . 'barang_id'" value="Barang yang Dipinjam" />
            <div class="flex gap-2">
                <input id="{{ $fieldPrefix }}barcode" type="text" placeholder="Masukkan ID barang" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300/40" />
                <x-button type="button" id="{{ $fieldPrefix }}check-barcode" class="whitespace-nowrap">Cek ID Barang</x-button>
            </div>
            <div id="{{ $fieldPrefix }}barcode-result" class="text-xs text-gray-500"></div>
            <select id="{{ $fieldPrefix }}barang_id" name="barang_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300/40">
                <option value="">-- Pilih Barang --</option>
                @foreach ($inventories as $inventory)
                    <option value="{{ $inventory->id }}">{{ $inventory->nama_barang }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('barang_id')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label :for="$fieldPrefix . 'tanggal_pinjam'" value="Tanggal & Waktu Pinjam" />
            <x-text-input id="{{ $fieldPrefix }}tanggal_pinjam" name="tanggal_pinjam" type="date" placeholder="dd/mm/yyyy" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300/40" />
            <x-input-error :messages="$errors->get('tanggal_pinjam')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label :for="$fieldPrefix . 'tanggal_kembali'" value="Tanggal & Waktu Kembali" />
            <x-text-input id="{{ $fieldPrefix }}tanggal_kembali" name="tanggal_kembali" type="date" placeholder="dd/mm/yyyy" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300/40" />
            <x-input-error :messages="$errors->get('tanggal_kembali')" class="mt-2" />
        </div>

        <div class="space-y-2 lg:col-span-2">
            <x-input-label :for="$fieldPrefix . 'keterangan'" value="Keterangan" />
            <textarea id="{{ $fieldPrefix }}keterangan" name="keterangan" rows="3" placeholder="Contoh: untuk praktikum jaringan" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300/40"></textarea>
            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
        </div>
    </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:justify-end gap-3">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">{{ $submitLabel }}</button>
        <button type="reset" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">Reset</button>
    </div>
</form>

