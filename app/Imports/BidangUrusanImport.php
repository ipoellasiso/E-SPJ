<?php

namespace App\Imports;

use App\Models\BidangUrusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BidangUrusanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode']) || !isset($row['nama']) || !isset($row['id_urusan'])) {
            return null;
        }

        return new BidangUrusan([
            'kode' => $row['kode'],
            'nama' => $row['nama'],
            'id_urusan' => $row['id_urusan'],
        ]);
    }
}
