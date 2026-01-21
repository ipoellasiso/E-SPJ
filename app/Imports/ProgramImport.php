<?php

namespace App\Imports;

use App\Models\Program;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProgramImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode']) || !isset($row['nama']) || !isset($row['id_bidang'])) {
            return null;
        }

        if (!DB::table('bidang_urusan')->where('id', $row['id_bidang'])->exists()) {
            return null;
        }

        Program::create([
            'kode' => $row['kode'],
            'nama' => $row['nama'],
            'id_bidang' => $row['id_bidang'],
        ]);
    }
}
