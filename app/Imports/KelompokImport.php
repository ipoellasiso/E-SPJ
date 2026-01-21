<?php

namespace App\Imports;

use App\Models\Kelompok;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelompokImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Pastikan semua kolom yang dibutuhkan tersedia
        if (!isset($row['kode']) || !isset($row['uraian']) || !isset($row['id_akun'])) {
            return null;
        }

        // Cek apakah id_akun ada di tabel akun
        $akunExists = DB::table('akun')
            ->where('id', $row['id_akun'])
            ->exists();

        if (!$akunExists) {
            // Skip baris ini kalau id_akun tidak valid
            return null;
        }

        // Simpan data ke tabel kelompok
        return new Kelompok([
            'kode'   => $row['kode'],
            'uraian' => $row['uraian'],
            'id_akun'=> $row['id_akun'],
        ]);
    }
}
