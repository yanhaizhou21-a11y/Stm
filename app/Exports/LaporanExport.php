<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tanggal_mulai;
    protected $tanggal_selesai;

    public function __construct($tanggal_mulai = null, $tanggal_selesai = null)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
    }

    public function collection(): Collection
    {
        $query = Peminjaman::with(['barang', 'peminjam', 'pengembalian'])
            ->when($this->tanggal_mulai && $this->tanggal_selesai, function ($q) {
                return $q->whereBetween(DB::raw('DATE(tanggal_pinjam)'), [$this->tanggal_mulai, $this->tanggal_selesai]);
            })
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();
        
        return $query->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'peminjam_id' => $item->peminjam_id,
                'role' => $item->role_label,
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
    }

    public function headings(): array
    {
        return [
            'ID Peminjaman',
            'ID Peminjam',
            'Peminjam',
            'Nama Barang',
            'Tanggal Pinjam',
            'Tanggal Kembali (Estimasi)',
            'Status Peminjaman',
            'Catatan Pengembalian',
            'Tanggal Dikembalikan',
            'Status Barang Saat Kembali',
        ];
    }

    public function map($row): array
    {
        $roleLabel = $row->role ?? '';
        if (str_contains($roleLabel, 'Student') || str_contains($roleLabel, 'student')) {
            $roleLabel = 'Siswa';
        } elseif (str_contains($roleLabel, 'Teacher') || str_contains($roleLabel, 'teacher')) {
            $roleLabel = 'Guru';
        } else {
            $roleLabel = ucfirst($roleLabel);
        }
        
        return [
            $row->id,
            $row->peminjam_id,
            $roleLabel . ' - ' . ($row->peminjam_nama ?? '-'),
            $row->barang,
            $row->tanggal_pinjam ? date('d M Y', strtotime($row->tanggal_pinjam)) : '-',
            $row->tanggal_kembali ? date('d M Y', strtotime($row->tanggal_kembali)) : '-',
            ucfirst($row->status),
            $row->catatan ?? '-',
            $row->tanggal_dikembalikan ? date('d M Y H:i', strtotime($row->tanggal_dikembalikan)) : '-',
            ucfirst($row->status_barang ?? '-'),
        ];
    }
}

