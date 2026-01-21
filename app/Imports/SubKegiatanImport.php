<?php

namespace App\Imports;

use App\Models\SubKegiatan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubKegiatanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode']) || !isset($row['nama']) || !isset($row['id_kegiatan'])) {
            return null;
        }

        if (!DB::table('kegiatan')->where('id', $row['id_kegiatan'])->exists()) {
            return null;
        }

        return new SubKegiatan([
            'kode' => $row['kode'],
            'nama' => $row['nama'],
            'id_kegiatan' => $row['id_kegiatan'],
        ]);
    }
}
