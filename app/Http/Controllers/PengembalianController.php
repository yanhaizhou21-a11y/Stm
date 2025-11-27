<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pengembalian\StorePengembalianRequest;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    public function index(): View
    {
        $peminjaman = Peminjaman::with(['barang', 'peminjam'])
            ->where('status', 'dipinjam')
            ->latest('tanggal_pinjam')
            ->get();

        return view('pengembalian.index', compact('peminjaman'));
    }

    public function create(Peminjaman $peminjaman): View
    {
        $peminjaman->load(['barang', 'peminjam']);
        return view('pengembalian.create', compact('peminjaman'));
    }

    public function store(StorePengembalianRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['checked_by'] = (string) Auth::id();
        
        // Convert datetime-local format to datetime format for database
        if (isset($validated['tanggal_dikembalikan'])) {
            $validated['tanggal_dikembalikan'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $validated['tanggal_dikembalikan'])));
        }

        $pengembalian = Pengembalian::create($validated);

        // Update status peminjaman
        $peminjaman = Peminjaman::findOrFail($validated['peminjaman_id']);
        $peminjaman->update(['status' => $validated['status_barang']]);

        return redirect()->route('pengembalian.index')
            ->with('success', 'Pengembalian berhasil disimpan.');
    }

    public function show(Pengembalian $pengembalian): View
    {
        $pengembalian->load(['peminjaman.barang', 'peminjaman.peminjam']);
        return view('pengembalian.show', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian): View
    {
        $pengembalian->load(['peminjaman.barang', 'peminjaman.peminjam']);
        return view('pengembalian.edit', compact('pengembalian'));
    }

    public function update(StorePengembalianRequest $request, Pengembalian $pengembalian): RedirectResponse
    {
        $validated = $request->validated();
        $validated['checked_by'] = (string) Auth::id();
        
        // Convert datetime-local format to datetime format for database
        if (isset($validated['tanggal_dikembalikan'])) {
            $validated['tanggal_dikembalikan'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $validated['tanggal_dikembalikan'])));
        }

        $pengembalian->update($validated);

        // Update status peminjaman
        $peminjaman = Peminjaman::findOrFail($validated['peminjaman_id']);
        $peminjaman->update(['status' => $validated['status_barang']]);

        return redirect()->route('pengembalian.index')
            ->with('success', 'Pengembalian berhasil diperbarui.');
    }
}
