<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default admin
        Admin::create([
            'username' => 'admin',
            'name' => 'System Administrator',
            'email' => 'admin@schoolms.com',
            'password' => 'password', // Will be hashed by the model mutator
            'role' => 'super_admin',
            'status' => 'active',
            'active_at' => now(),
        ]);

        // Create additional admins using factory
        Admin::factory(3)->active()->create();
        Admin::factory(2)->inactive()->create();
    }
}
