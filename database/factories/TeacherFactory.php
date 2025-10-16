<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nip' => fake()->unique()->numerify('NIP########'),
            'nama_lengkap' => fake()->name(),
            'jabatan' => fake()->randomElement(['Guru Matematika', 'Guru Bahasa Indonesia', 'Guru IPA', 'Guru IPS', 'Guru Bahasa Inggris']),
            'no_hp' => fake()->numerify('08##########'),
            'email' => fake()->unique()->safeEmail(),
            'alamat' => fake()->address(),
            'is_active' => fake()->boolean(90),
        ];
    }
}