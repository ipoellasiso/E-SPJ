<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akun;
use App\Models\Kelompok;
use App\Models\Jenis;
use App\Models\Objek;
use App\Models\RincianObjek;
use App\Models\SubRincianObjek;

class RekeningSeeder extends Seeder
{
    public function run(): void
    {
        // === AKUN ===
        $akun5 = Akun::create([
            'kode' => '5',
            'uraian' => 'BELANJA DAERAH'
        ]);

        // === KELOMPOK ===
        $kelompok51 = Kelompok::create([
            'akun_id' => $akun5->id,
            'kode' => '5.1',
            'uraian' => 'BELANJA OPERASI'
        ]);

        // === JENIS ===
        $jenis5101 = Jenis::create([
            'kelompok_id' => $kelompok51->id,
            'kode' => '5.1.01',
            'uraian' => 'BELANJA PEGAWAI'
        ]);

        $jenis5102 = Jenis::create([
            'kelompok_id' => $kelompok51->id,
            'kode' => '5.1.02',
            'uraian' => 'BELANJA BARANG DAN JASA'
        ]);

        // === OBJEK ===
        $objekHonor = Objek::create([
            'jenis_id' => $jenis5101->id,
            'kode' => '5.1.01.03',
            'uraian' => 'Belanja Honorarium'
        ]);

        $objekBarang = Objek::create([
            'jenis_id' => $jenis5102->id,
            'kode' => '5.1.02.01',
            'uraian' => 'Belanja Bahan Pakai Habis'
        ]);

        // === RINCIAN OBJEK ===
        $rincianHonor = RincianObjek::create([
            'objek_id' => $objekHonor->id,
            'kode' => '5.1.01.03.07',
            'uraian' => 'Belanja Honorarium Penanggungjawab Kegiatan'
        ]);

        $rincianBarang = RincianObjek::create([
            'objek_id' => $objekBarang->id,
            'kode' => '5.1.02.01.001',
            'uraian' => 'Belanja Bahan-Bahan Lainnya'
        ]);

        // === SUB RINCIAN OBJEK ===
        SubRincianObjek::insert([
            [
                'rincian_objek_id' => $rincianHonor->id,
                'kode' => '5.1.01.03.07.0001',
                'uraian' => 'Honor PPTK'
            ],
            [
                'rincian_objek_id' => $rincianHonor->id,
                'kode' => '5.1.01.03.07.0002',
                'uraian' => 'Honor PNS'
            ],
            [
                'rincian_objek_id' => $rincianBarang->id,
                'kode' => '5.1.02.01.001.0001',
                'uraian' => 'Belanja Bahan-Bahan Lainnya (Stand Promosi)'
            ],
        ]);

        $this->command->info('✅ Data rekening berhasil di-seed!');
    }
}
