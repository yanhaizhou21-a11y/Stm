<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'id',
        'peminjam_id',
        'role',
        'barang_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'keterangan',
        'added_by',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    protected $attributes = [
        'status' => 'dipinjam',
    ];

    public function peminjam(): MorphTo
    {
        return $this->morphTo(null, 'role', 'peminjam_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'barang_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }

    public function getPeminjamNamaAttribute(): ?string
    {
        try {
            $peminjam = $this->peminjam;
            return $peminjam?->nama_lengkap ?? $peminjam?->name ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getRoleLabelAttribute(): string
    {
        if (class_exists($this->role)) {
            return ucfirst(strtolower(class_basename($this->role)));
        }
        return ucfirst($this->role ?? '');
    }
}
