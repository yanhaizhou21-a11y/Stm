<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nisn',
        'nama_lengkap',
        'kelas',
        'jurusan',
        'angkatan',
        'alamat',
        'no_hp',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}