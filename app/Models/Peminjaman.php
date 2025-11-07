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
        'peminjam_id',
        'role',
        'barang_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'keterangan',
        'added_by',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];

    public function peminjam(): MorphTo
    {
        return $this->morphTo(null, 'role', 'peminjam_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'barang_id');
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function getPeminjamNamaAttribute(): ?string
    {
        $peminjam = $this->peminjam;

        return $peminjam?->nama_lengkap ?? $peminjam?->name ?? null;
    }

    public function getRoleLabelAttribute(): string
    {
        return ucfirst(strtolower(class_basename($this->role)));
    }
}
