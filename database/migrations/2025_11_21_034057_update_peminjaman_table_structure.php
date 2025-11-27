<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['barang_id']);
            $table->dropForeign(['added_by']);
            
            // Change column types
            $table->string('peminjam_id')->change();
            $table->string('role')->change();
            $table->string('barang_id')->change();
            $table->date('tanggal_pinjam')->change();
            $table->date('tanggal_kembali')->nullable()->change();
            $table->string('added_by')->change();
            
            // Add status column
            $table->string('status')->default('dipinjam')->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Revert column types
            $table->unsignedBigInteger('peminjam_id')->change();
            $table->string('role', 120)->change();
            $table->foreignId('barang_id')->change();
            $table->dateTime('tanggal_pinjam')->change();
            $table->dateTime('tanggal_kembali')->nullable()->change();
            $table->foreignId('added_by')->change();
            
            // Remove status column
            $table->dropColumn('status');
            
            // Re-add foreign keys
            $table->foreign('barang_id')->references('id')->on('inventories')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
