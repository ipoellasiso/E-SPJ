<?php

namespace App\Imports;

use App\Models\SubRincianObjek;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubRincianObjekImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode']) || !isset($row['uraian']) || !isset($row['id_rincian_objek'])) return null;

        if (!DB::table('rincian_objek')->where('id', $row['id_rincian_objek'])->exists()) return null;

        return new SubRincianObjek([
            'kode' => $row['kode'],
            'uraian' => $row['uraian'],
            'id_rincian_objek' => $row['id_rincian_objek'],
        ]);
    }
}
