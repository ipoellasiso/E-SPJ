<?php

namespace App\Imports;

use App\Models\Akun;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AkunImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode']) || !isset($row['uraian'])) return null;

        return new Akun([
            'kode' => $row['kode'],
            'uraian' => $row['uraian'],
        ]);
    }
}
