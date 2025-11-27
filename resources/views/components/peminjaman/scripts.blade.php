@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    // setup CSRF for fetch
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    function headers() {
        return {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken || ''
        };
    }

    // Initialize DataTable (server-side)
    if (document.querySelector('#peminjaman-table')) {
        const dt = $('#peminjaman-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('peminjaman.data') }}',
            pageLength: 10,
            responsive: true,
            order: [[4, 'desc']],
            columns: [
                { data: 'peminjam', name: 'peminjam' },
                { data: 'nama', name: 'nama' },
                { data: 'barang', name: 'barang' },
                { data: 'id_barang', name: 'id_barang' },
                { data: 'tanggal_pinjam', name: 'tanggal_pinjam' },
                { data: 'tanggal_kembali', name: 'tanggal_kembali' },
                { data: 'status', name: 'status', orderable: false },
                { data: 'keterangan', name: 'keterangan' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
        });

        // Delete function
        window.deletePeminjaman = function(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                const url = '{{ url("peminjaman") }}/' + id;
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert('Data berhasil dihapus');
                    dt.ajax.reload();
                })
                .catch(error => {
                    alert('Terjadi kesalahan!');
                    console.error(error);
                });
            }
        };
    }

    // Modal open for Create
    const createModalId = 'create-peminjaman-modal';

    // EDIT modal logic (reuse modal component)
    const editModal = document.getElementById('edit-peminjaman-modal');
    const editForm = document.getElementById('edit-peminjaman-form');
    const createModal = document.getElementById('create-peminjaman-modal');
    const createForm = document.getElementById('create-peminjaman-form');

    function openModal(modal) {
        modal?.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeModal(modal) {
        modal?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // close buttons
    document.querySelectorAll('[data-close-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const m = btn.closest('[id]');
            if (m) closeModal(m);
        });
    });

    // click outside to close
    if (editModal) {
        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) closeModal(editModal);
        });
    }
    if (createModal) {
        createModal.addEventListener('click', (e) => {
            if (e.target === createModal) closeModal(createModal);
        });
    }
    // Open create modal
    const createBtn = document.querySelector('[data-open-create]');
    if (createBtn && createModal) {
        createBtn.addEventListener('click', () => {
            // reset form
            createForm?.reset();
            openModal(createModal);
        });
    }

    // AJAX submit create
    if (createForm) {
        createForm.addEventListener('submit', async (e) => {
            // allow normal submit if fetch fails; but try AJAX for better UX
            e.preventDefault();
            const formData = new FormData(createForm);
            try {
                const res = await fetch(createForm.action, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: formData
                });
                if (!res.ok) throw new Error('Gagal menyimpan');
                closeModal(createModal);
                $('#peminjaman-table').DataTable().ajax.reload(null, false);
            } catch (err) {
                alert(err.message || 'Terjadi kesalahan');
            }
        });
    }

    // AJAX submit update
    if (editForm) {
        editForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(editForm);
            try {
                const res = await fetch(editForm.action, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: formData
                });
                if (!res.ok) throw new Error('Gagal memperbarui');
                closeModal(editModal);
                $('#peminjaman-table').DataTable().ajax.reload(null, false);
            } catch (err) {
                alert(err.message || 'Terjadi kesalahan');
            }
        });
    }

    // Edit button click: fetch data and populate (delegated to support DataTables redraws)
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-edit-button]');
        if (!btn) return;
        const id = btn.dataset.id;
        if (!id || !editForm) return;

        try {
            const res = await fetch(`{{ url('peminjaman') }}/${id}/edit`, { headers: headers() });
            if (!res.ok) throw new Error('Gagal mengambil data');

            const payload = await res.json();
            const data = payload.data;

            editForm.action = `{{ url('peminjaman') }}/${id}`;
            let methodInput = editForm.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                editForm.appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            const setDate = (selector, value) => {
                const el = editForm.querySelector(selector);
                if (!el) return;
                el.value = value || '';
            };
            if (editForm.querySelector('[name="role"]')) editForm.querySelector('[name="role"]').value = data.role || '';
            if (editForm.querySelector('[name="peminjam_id"]')) editForm.querySelector('[name="peminjam_id"]').value = data.peminjam_id || '';
            if (editForm.querySelector('[name="barang_id"]')) editForm.querySelector('[name="barang_id"]').value = data.barang_id || '';
            setDate('[name="tanggal_pinjam"]', data.tanggal_pinjam);
            setDate('[name="tanggal_kembali"]', data.tanggal_kembali);
            if (editForm.querySelector('[name="keterangan"]')) editForm.querySelector('[name="keterangan"]').value = data.keterangan || '';

            openModal(editModal);
        } catch (err) {
            alert(err.message || 'Terjadi kesalahan');
        }
    });

    // Barcode check logic (works for any form instance with elements matching pattern)
    function attachBarcodeChecker(prefix = '') {
        const barcodeInput = document.getElementById(prefix + 'barcode');
        const checkBtn = document.getElementById(prefix + 'check-barcode');
        const resultBox = document.getElementById(prefix + 'barcode-result');
        const barangSelect = document.getElementById(prefix + 'barang_id');

        if (!barcodeInput || !checkBtn) return;

        async function checkBarcode(code) {
            try {
                const res = await fetch(`{{ route('inventories.check') }}?code=${encodeURIComponent(code)}`, {
                    headers: headers()
                });
                if (!res.ok) {
                    const txt = await res.text();
                    throw new Error(txt || 'Gagal memeriksa kode');
                }
                const json = await res.json();
                return json;
            } catch (e) {
                return { error: e.message || 'Terjadi kesalahan' };
            }
        }

        // click check
        checkBtn.addEventListener('click', async () => {
            const code = barcodeInput.value.trim();
            if (!code) {
                resultBox.textContent = 'Masukkan kode terlebih dahulu.';
                resultBox.className = 'text-sm text-red-500';
                return;
            }
            resultBox.textContent = 'Memeriksa...';
            const r = await checkBarcode(code);
            if (r.error) {
                resultBox.textContent = 'Tidak ditemukan: ' + r.error;
                resultBox.className = 'text-sm text-red-500';
            } else {
                // r should contain id & nama
                resultBox.textContent = `Ditemukan: ${r.nama_barang} (ID: ${r.id})`;
                resultBox.className = 'text-sm text-green-600';

                if (barangSelect) {
                    barangSelect.value = r.id;
                }
            }
        });

        // allow scanner to trigger check on Enter
        barcodeInput.addEventListener('keydown', async (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                checkBtn.click();
            }
        });
    }

    // Attach to both create & edit prefixes (adjust IDs if different)
    attachBarcodeChecker(''); // default form without prefix
    attachBarcodeChecker('create-');
    attachBarcodeChecker('edit-');

    // Peminjam ID checker: find matching option and select it
    function attachPeminjamChecker(prefix = '') {
        const input = document.getElementById(prefix + 'peminjam_lookup');
        const btn = document.getElementById(prefix + 'check-peminjam');
        const result = document.getElementById(prefix + 'peminjam-result');
        const select = document.getElementById(prefix + 'peminjam_id');
        const formEl = (select || input)?.closest('form');
        const roleSelect = formEl?.querySelector('[data-role-select]');

        if (!input || !btn || !select) return;

        btn.addEventListener('click', async () => {
            const code = input.value.trim();
            if (!code) {
                result.textContent = 'Masukkan ID terlebih dahulu.';
                result.className = 'text-xs text-red-500';
                return;
            }
            const role = roleSelect?.value || '';
            if (!role) {
                result.textContent = 'Pilih jenis peminjam terlebih dahulu.';
                result.className = 'text-xs text-red-500';
                return;
            }
            try {
                const res = await fetch(`{{ route('peminjaman.check') }}?role=${encodeURIComponent(role)}&code=${encodeURIComponent(code)}`);
                const json = await res.json();
                if (!res.ok || json.error) throw new Error(json.error || 'Gagal memeriksa');
                // set role and select found peminjam id
                if (roleSelect) {
                    roleSelect.value = json.role;
                    roleSelect.dispatchEvent(new Event('change'));
                }
                if (select) select.value = String(json.id);
                result.textContent = `Ditemukan: ${json.nama}`;
                result.className = 'text-xs text-green-600';
            } catch (e) {
                result.textContent = e.message || 'Tidak ditemukan';
                result.className = 'text-xs text-red-500';
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                btn.click();
            }
        });
    }

    attachPeminjamChecker('');
    attachPeminjamChecker('create-');
    attachPeminjamChecker('edit-');

    // OPTIONAL: AJAX submit handlers can be added to submit form via fetch and then refresh DataTable or reload page.
});
</script>
@endpush
