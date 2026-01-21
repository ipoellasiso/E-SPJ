<?php

namespace App\Imports;

use App\Models\RincianAnggaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class RincianImport implements ToCollection
{
    protected $id_anggaran;

    public function __construct($id_anggaran)
    {
        $this->id_anggaran = $id_anggaran;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows->skip(1) as $row) { // skip header row
            if (empty($row[0])) continue;

            RincianAnggaran::create([
                'id_anggaran' => $this->id_anggaran,
                'kode_rekening' => trim($row[0]),
                'uraian'        => $row[1],
                'koefisien'     => $row[2] ?? 0,
                'satuan'        => $row[3] ?? '',
                'harga'         => $row[4] ?? 0,
                'jumlah'        => $row[5] ?? 0,
            ]);
        }
    }
}
