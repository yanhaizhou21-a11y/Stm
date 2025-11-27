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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_id');
            $table->enum('status_barang', ['dikembalikan', 'rusak', 'hilang']);
            $table->dateTime('tanggal_dikembalikan');
            $table->text('catatan')->nullable();
            $table->string('checked_by');
            $table->timestamps();
            
            $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
