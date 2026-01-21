<?php

namespace App\Imports;

use App\Models\RincianObjek;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RincianObjekImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode']) || !isset($row['uraian']) || !isset($row['id_objek'])) return null;

        if (!DB::table('objek')->where('id', $row['id_objek'])->exists()) return null;

        return new RincianObjek([
            'kode' => $row['kode'],
            'uraian' => $row['uraian'],
            'id_objek' => $row['id_objek'],
        ]);
    }
}
