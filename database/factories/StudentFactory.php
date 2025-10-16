<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nisn' => fake()->unique()->numerify('##########'),
            'nama_lengkap' => fake()->name(),
            'kelas' => fake()->randomElement(['X', 'XI', 'XII']) . '-' . fake()->randomElement(['A', 'B', 'C']),
            'jurusan' => fake()->randomElement(['IPA', 'IPS', 'Bahasa']),
            'angkatan' => fake()->randomElement(['2022', '2023', '2024', '2025']),
            'alamat' => fake()->address(),
            'no_hp' => fake()->numerify('08##########'),
            'is_active' => fake()->boolean(95),
        ];
    }
}