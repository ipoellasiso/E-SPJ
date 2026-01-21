<?php

namespace App\Imports;

use App\Models\Objek;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ObjekImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode']) || !isset($row['uraian']) || !isset($row['id_jenis'])) {
            return null;
        }

        if (!DB::table('jenis')->where('id', $row['id_jenis'])->exists()) {
            return null;
        }

        return new Objek([
            'kode' => $row['kode'],
            'uraian' => $row['uraian'],
            'id_jenis' => $row['id_jenis'],
        ]);
    }
}
