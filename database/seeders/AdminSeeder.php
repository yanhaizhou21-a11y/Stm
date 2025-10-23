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
        $admins = [
            [
                'username' => 'admin',
                'name' => 'System Administrator',
                'email' => 'admin@schoolms.com',
                'active_at' => now(),
            ],
            [
                'username' => 'john_doe',
                'name' => 'John Doe',
                'email' => 'john.doe@schoolms.com',
                'active_at' => now()->subDays(30),
            ],
            [
                'username' => 'jane_smith',
                'name' => 'Jane Smith',
                'email' => 'jane.smith@schoolms.com',
                'active_at' => now()->subDays(15),
            ],
            [
                'username' => 'mike_wilson',
                'name' => 'Mike Wilson',
                'email' => 'mike.wilson@schoolms.com',
                'active_at' => now()->subDays(7),
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
