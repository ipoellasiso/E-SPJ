<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('urusan')->insert([
            ['kode' => '2', 'nama' => 'URUSAN PEMERINTAHAN WAJIB YANG TIDAK BERKAITAN DENGAN PELAYANAN DASAR']
        ]);

        DB::table('bidang_urusan')->insert([
            ['id_urusan' => 1, 'kode' => '2.18', 'nama' => 'URUSAN PEMERINTAHAN BIDANG PENANAMAN MODAL']
        ]);

        DB::table('unit_organisasi')->insert([
            ['id_bidang' => 1, 'kode' => '2.18.0.00.0.00.14.0000', 'nama' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU']
        ]);

        DB::table('program')->insert([
            ['id_unit' => 1, 'kode' => '2.18.03', 'nama' => 'PROGRAM PROMOSI PENANAMAN MODAL']
        ]);

        DB::table('kegiatan')->insert([
            ['id_program' => 1, 'kode' => '2.18.03.21', 'nama' => 'Penyelenggaraan Promosi Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/Kota']
        ]);

        DB::table('sub_kegiatan')->insert([
            ['id_kegiatan' => 1, 'kode' => '2.18.03.21.01.0002', 'nama' => 'Pelaksanaan Kegiatan Promosi Penanaman Modal Daerah Kabupaten/Kota']
        ]);
    }
}
