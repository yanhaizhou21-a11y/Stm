<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default user (check if exists first)
        if (!User::where('email', 'admin@school.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@school.com',
                'password' => bcrypt('password')
            ]);
        }

        // Create sample data
        Teacher::factory(5)->create();
        Student::factory(5)->create();
        Category::factory(3)->create();
        Inventory::factory(5)->create();
        
        // Seed admin data
        $this->call(AdminSeeder::class);
        
        // Seed peminjaman data
        $this->call(PeminjamanSeeder::class);
    }
}