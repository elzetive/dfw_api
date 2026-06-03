<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Membersihkan data lama agar id string tidak bentrok (Truncate Cascading)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('units')->truncate();
        DB::table('konsols')->truncate();
        DB::table('tvs')->truncate();
        DB::table('pelanggans')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('konsols')->insert([
            [
                'id' => 'KSL-01',
                'nama_unit' => 'PS3 Super Slim 01',
                'tipe' => 'PS3', // <--- Ditambahkan data default PS3
                'kondisi' => 'Baik',
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'KSL-02',
                'nama_unit' => 'PS4 Slim Pro 01',
                'tipe' => 'PS4',
                'kondisi' => 'Baik',
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'KSL-03',
                'nama_unit' => 'PS5 Digital Edition 01',
                'tipe' => 'PS5',
                'kondisi' => 'Baik',
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('tvs')->insert([
            [
                'id' => 'TV-01',
                'nama_tv' => 'LG LED Gaming',
                'model' => 'LG-32UK',
                'kondisi' => 'Baik',
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'TV-02',
                'nama_tv' => 'Samsung Crystal UHD',
                'model' => 'SS-43AU',
                'kondisi' => 'Baik',
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('units')->insert([
            [
                'id' => 1,
                'nama_unit' => 'Unit 1 - PS 5 Regular',
                'konsol_id' => 'KSL-03',
                'tv_id' => 'TV-02',
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama_unit' => 'Unit 2 - PS 4 Hemat',
                'konsol_id' => 'KSL-02',
                'tv_id' => 'TV-01',
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('pelanggans')->insert([
            [
                'id' => 1,
                'nama_pelanggan' => 'Dimas Riyan Wirayuda',
                'telepon' => '081226723902',
                'alamat' => 'Jalan Kemangi No 41, Cilacap',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama_pelanggan' => 'Figo Firgiawan',
                'telepon' => '081226723908',
                'alamat' => 'Karangtengah, Cilongok, Banyumas',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
