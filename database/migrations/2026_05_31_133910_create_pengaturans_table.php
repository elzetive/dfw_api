<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('pengaturans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_usaha');
        $table->string('jam_operasional');
        $table->integer('harga_ps3');
        $table->integer('harga_ps4');
        $table->integer('harga_ps5');
        $table->timestamps();
    });
}
};
