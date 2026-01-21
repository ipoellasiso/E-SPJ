<?php

namespace App\Imports;

use App\Models\UnitOrganisasi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitOrganisasiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode']) || !isset($row['nama']) || !isset($row['id_bidang'])) {
            return null;
        }

        // pastikan id_bidang valid
        $exists = DB::table('bidang_urusan')->where('id', $row['id_bidang'])->exists();
        if (!$exists) return null;

        return new UnitOrganisasi([
            'kode' => $row['kode'],
            'nama' => $row['nama'],
            'id_bidang' => $row['id_bidang'],
        ]);
    }
}
