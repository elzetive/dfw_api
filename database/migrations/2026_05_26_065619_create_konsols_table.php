<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsols', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama_unit');
            // PERBAIKAN: Mengubah enum default agar hanya menerima PS3, PS4, PS5
            $table->enum('tipe', ['PS3', 'PS4', 'PS5']);
            $table->enum('kondisi', ['Baik', 'Rusak', 'Dalam Perbaikan'])->default('Baik');
            $table->enum('status', ['Tersedia', 'Tidak Tersedia', 'Maintenance'])->default('Tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsols');
    }
};
