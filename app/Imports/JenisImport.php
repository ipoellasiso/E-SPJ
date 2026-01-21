<?php

namespace App\Imports;

use App\Models\Jenis;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JenisImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode']) || !isset($row['uraian']) || !isset($row['id_kelompok'])) {
            return null;
        }

        if (!DB::table('kelompok')->where('id', $row['id_kelompok'])->exists()) {
            return null;
        }

        return new Jenis([
            'kode' => $row['kode'],
            'uraian' => $row['uraian'],
            'id_kelompok' => $row['id_kelompok'],
        ]);
    }
}
