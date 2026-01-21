<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggaran;
use App\Models\RincianAnggaran;
use App\Models\SubKegiatan;

class AnggaranSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada sub_kegiatan minimal 1
        $sub = SubKegiatan::firstOrCreate([
            'id_kegiatan' => 1,
            'kode' => '2.18.03.21.01.0002',
            'nama' => 'Pelaksanaan Kegiatan Promosi Penanaman Modal Daerah Kabupaten/Kota'
        ]);

        // === ANGGARAN UTAMA ===
        $anggaran = Anggaran::create([
            'id_subkegiatan' => $sub->id,
            'tahun' => 2025,
            'sumber_dana' => 'Dana Transfer Umum - Dana Alokasi Umum',
            'lokasi' => 'Kota Serang, Kecamatan Serang, Kelurahan Kota Baru',
            'waktu_pelaksanaan' => 'Januari s.d Desember',
            'kelompok_sasaran' => 'Calon Investor',
            'pagu_anggaran' => 182267500,
            'keterangan' => 'Kegiatan Promosi Penanaman Modal'
        ]);

        // === RINCIAN HIERARKIS ===
        $r1 = RincianAnggaran::create([
            'id_anggaran' => $anggaran->id,
            'kode_rekening' => '5',
            'uraian' => 'BELANJA DAERAH',
            'jumlah' => 182267500,
            'urutan' => 1
        ]);

        $r2 = RincianAnggaran::create([
            'id_anggaran' => $anggaran->id,
            'kode_rekening' => '5.1',
            'uraian' => 'BELANJA OPERASI',
            'jumlah' => 182267500,
            'id_parent' => $r1->id,
            'urutan' => 2
        ]);

        $r3 = RincianAnggaran::create([
            'id_anggaran' => $anggaran->id,
            'kode_rekening' => '5.1.01',
            'uraian' => 'BELANJA PEGAWAI',
            'id_parent' => $r2->id,
            'jumlah' => 4840000,
            'urutan' => 3
        ]);

        $r4 = RincianAnggaran::create([
            'id_anggaran' => $anggaran->id,
            'kode_rekening' => '5.1.01.03',
            'uraian' => 'Belanja Honorarium',
            'id_parent' => $r3->id,
            'jumlah' => 4840000,
            'urutan' => 4
        ]);

        $r5 = RincianAnggaran::create([
            'id_anggaran' => $anggaran->id,
            'kode_rekening' => '5.1.01.03.07.0001',
            'uraian' => 'Honor PPTK',
            'koefisien' => '4',
            'satuan' => 'Orang/Bulan',
            'harga' => 1210000,
            'jumlah' => 4840000,
            'id_parent' => $r4->id,
            'keterangan' => 'Pejabat Pelaksana Teknis Kegiatan (PPTK)',
            'urutan' => 5
        ]);

        // Belanja barang
        $r6 = RincianAnggaran::create([
            'id_anggaran' => $anggaran->id,
            'kode_rekening' => '5.1.02',
            'uraian' => 'BELANJA BARANG DAN JASA',
            'jumlah' => 177427500,
            'id_parent' => $r2->id,
            'urutan' => 6
        ]);

        RincianAnggaran::create([
            'id_anggaran' => $anggaran->id,
            'kode_rekening' => '5.1.02.01.01.0012',
            'uraian' => 'Belanja Bahan-Bahan Lainnya (Stand Promosi)',
            'koefisien' => '1',
            'satuan' => 'Paket',
            'harga' => 25000000,
            'jumlah' => 25000000,
            'id_parent' => $r6->id,
            'urutan' => 7,
            'keterangan' => 'Sumber Dana: Dana Transfer Umum - Dana Alokasi Umum'
        ]);
    }
}
