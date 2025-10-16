<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_kategori' => fake()->randomElement(['Elektronik', 'Furniture', 'Alat Tulis']),
            'deskripsi' => fake()->sentence(),
            'is_active' => fake()->boolean(95),
        ];
    }
}