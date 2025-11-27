<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(): View
    {
        return view('laporan.index');
    }

    public function filter(Request $request): View
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = $request->tanggal_selesai;

        // Optimasi query dengan select hanya field yang diperlukan
        // Gunakan Eloquent untuk mendapatkan data yang konsisten dengan peminjaman
        $laporan = Peminjaman::with(['barang', 'peminjam', 'pengembalian'])
            ->whereBetween(DB::raw('DATE(tanggal_pinjam)'), [$tanggal_mulai, $tanggal_selesai])
            ->orderBy('tanggal_pinjam', 'desc')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'peminjam_id' => $item->peminjam_id,
                    'role' => $item->role,
                    'role_label' => $item->role_label,
                    'peminjam_nama' => $item->peminjam_nama,
                    'barang' => $item->barang?->nama_barang ?? '-',
                    'tanggal_pinjam' => $item->tanggal_pinjam,
                    'tanggal_kembali' => $item->tanggal_kembali,
                    'status' => $item->status,
                    'catatan' => $item->pengembalian?->catatan ?? null,
                    'tanggal_dikembalikan' => $item->pengembalian?->tanggal_dikembalikan ?? null,
                    'status_barang' => $item->pengembalian?->status_barang ?? null,
                ];
            });

        return view('laporan.index', compact('laporan', 'tanggal_mulai', 'tanggal_selesai'));
    }

    public function exportExcel(Request $request)
    {
        $tanggal_mulai = $request->query('tanggal_mulai');
        $tanggal_selesai = $request->query('tanggal_selesai');

        if (class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
            return \Maatwebsite\Excel\Facades\Excel::download(new LaporanExport($tanggal_mulai, $tanggal_selesai), 'laporan-peminjaman.xlsx');
        }
        
        return redirect()->back()->with('error', 'Package Excel belum terinstall. Silakan install maatwebsite/excel terlebih dahulu.');
    }

    public function exportPdf(Request $request)
    {
        $tanggal_mulai = $request->query('tanggal_mulai');
        $tanggal_selesai = $request->query('tanggal_selesai');

        // Gunakan Eloquent untuk mendapatkan data yang konsisten dengan peminjaman
        $laporan = Peminjaman::with(['barang', 'peminjam', 'pengembalian'])
            ->when($tanggal_mulai && $tanggal_selesai, function ($q) use ($tanggal_mulai, $tanggal_selesai) {
                return $q->whereBetween(DB::raw('DATE(tanggal_pinjam)'), [$tanggal_mulai, $tanggal_selesai]);
            })
            ->orderBy('tanggal_pinjam', 'desc')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'peminjam_id' => $item->peminjam_id,
                    'role' => $item->role,
                    'role_label' => $item->role_label,
                    'peminjam_nama' => $item->peminjam_nama,
                    'barang' => $item->barang?->nama_barang ?? '-',
                    'tanggal_pinjam' => $item->tanggal_pinjam,
                    'tanggal_kembali' => $item->tanggal_kembali,
                    'status' => $item->status,
                    'catatan' => $item->pengembalian?->catatan ?? null,
                    'tanggal_dikembalikan' => $item->pengembalian?->tanggal_dikembalikan ?? null,
                    'status_barang' => $item->pengembalian?->status_barang ?? null,
                ];
            });

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', compact('laporan', 'tanggal_mulai', 'tanggal_selesai'));
            return $pdf->download('laporan-peminjaman.pdf');
        }
        
        return redirect()->back()->with('error', 'Package PDF belum terinstall. Silakan install barryvdh/laravel-dompdf terlebih dahulu.');
    }
}
