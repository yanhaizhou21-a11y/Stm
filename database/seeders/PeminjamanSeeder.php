<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing data
        $students = Student::where('is_active', true)->get();
        $teachers = Teacher::where('is_active', true)->get();
        $inventories = Inventory::where('is_active', true)->get();
        $users = User::all();

        if ($students->isEmpty() || $inventories->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Tidak ada data Student, Inventory, atau User. Silakan jalankan seeder lain terlebih dahulu.');
            return;
        }

        // Ambil ID inventory yang valid
        $inventoryIds = $inventories->pluck('id')->toArray();
        
        // Create peminjaman for students - dengan tanggal yang lebih luas untuk testing
        $studentCount = 0;
        foreach ($students->take(3) as $student) {
            if ($studentCount < count($inventoryIds)) {
                Peminjaman::create([
                    'peminjam_id' => (string) $student->id,
                    'role' => Student::class,
                    'barang_id' => (string) $inventoryIds[$studentCount],
                    'tanggal_pinjam' => Carbon::now()->subDays(rand(5, 15))->format('Y-m-d'),
                    'tanggal_kembali' => Carbon::now()->addDays(rand(1, 5))->format('Y-m-d'),
                    'keterangan' => 'Untuk keperluan pembelajaran',
                    'added_by' => (string) $users->first()->id,
                    'status' => 'dipinjam',
                ]);
                $studentCount++;
            }
        }

        // Create peminjaman for teachers
        $teacherCount = 0;
        foreach ($teachers->take(2) as $teacher) {
            $inventoryIndex = min($studentCount + $teacherCount, count($inventoryIds) - 1);
            if ($inventoryIndex < count($inventoryIds)) {
                Peminjaman::create([
                    'peminjam_id' => (string) $teacher->id,
                    'role' => Teacher::class,
                    'barang_id' => (string) $inventoryIds[$inventoryIndex],
                    'tanggal_pinjam' => Carbon::now()->subDays(rand(3, 12))->format('Y-m-d'),
                    'tanggal_kembali' => Carbon::now()->addDays(rand(1, 3))->format('Y-m-d'),
                    'keterangan' => 'Untuk keperluan mengajar',
                    'added_by' => (string) $users->first()->id,
                    'status' => 'dipinjam',
                ]);
                $teacherCount++;
            }
        }

        // Create some returned peminjaman
        if ($students->count() > 3 && count($inventoryIds) > 0) {
            Peminjaman::create([
                'peminjam_id' => (string) $students[3]->id,
                'role' => Student::class,
                'barang_id' => (string) $inventoryIds[0],
                'tanggal_pinjam' => Carbon::now()->subDays(20)->format('Y-m-d'),
                'tanggal_kembali' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'keterangan' => 'Sudah dikembalikan',
                'added_by' => (string) $users->first()->id,
                'status' => 'dikembalikan',
            ]);
        }

        $this->command->info('Data peminjaman berhasil dibuat!');
    }
}
