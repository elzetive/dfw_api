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
    Schema::create('tvs', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->string('nama_tv');
        $table->string('model');
        $table->enum('kondisi', ['Baik', 'Rusak', 'Dalam Perbaikan'])->default('Baik');
        $table->enum('status', ['Tersedia', 'Tidak Tersedia', 'Maintenance'])->default('Tersedia');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tvs');
    }
};
