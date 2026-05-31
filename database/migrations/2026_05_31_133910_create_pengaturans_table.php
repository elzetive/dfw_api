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
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_usaha');
            $table->string('jam_operasional');
            $table->integer('harga_ps4');
            $table->integer('harga_ps5');
            $table->integer('harga_xbox');
            $table->integer('harga_nintendo');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('pengaturans')->insert([
            'nama_usaha' => 'DFW Playstation',
            'jam_operasional' => '10.00 - 24.00',
            'harga_ps4' => 8000,
            'harga_ps5' => 12000,
            'harga_xbox' => 10000,
            'harga_nintendo' => 8000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
