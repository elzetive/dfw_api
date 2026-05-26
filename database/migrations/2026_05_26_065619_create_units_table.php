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
    Schema::create('units', function (Blueprint $table) {
        $table->id();
        $table->string('nama_unit');

        $table->string('konsol_id');
        $table->foreign('konsol_id')->references('id')->on('konsols')->onDelete('cascade');

        $table->string('tv_id');
        $table->foreign('tv_id')->references('id')->on('tvs')->onDelete('cascade');

        $table->enum('status', ['Tersedia', 'Tidak Tersedia', 'Maintenance'])->default('Tersedia');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
