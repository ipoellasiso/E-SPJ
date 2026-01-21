<?php

namespace App\Imports;

use App\Models\Kegiatan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KegiatanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode']) || !isset($row['nama']) || !isset($row['id_program'])) {
            return null;
        }

        if (!DB::table('program')->where('id', $row['id_program'])->exists()) {
            return null;
        }

        return new Kegiatan([
            'kode' => $row['kode'],
            'nama' => $row['nama'],
            'id_program' => $row['id_program'],
        ]);
    }
}
