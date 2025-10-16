<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode_barang' => fake()->unique()->bothify('BRG-####'),
            'nama_barang' => fake()->randomElement(['Laptop', 'Proyektor', 'Meja', 'Kursi', 'Papan Tulis', 'Printer']),
            'kategori_id' => Category::factory(),
            'deskripsi' => fake()->sentence(),
            'status' => fake()->randomElement(['Baik', 'Rusak', 'Diperbaiki']),
            'lokasi_barang' => fake()->randomElement(['Ruang Kelas A', 'Ruang Guru', 'Lab Komputer', 'Perpustakaan']),
            'is_active' => fake()->boolean(90),
        ];
    }
}