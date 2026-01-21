<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TemplateRincianExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'Kode Rekening',
            'Uraian',
            'Koefisien',
            'Satuan',
            'Harga',
            'Jumlah'
        ];
    }

    public function array(): array
    {
        return [
            ['5.1.01.03.07.0001', 'Honor PNS', '5', 'Orang/Bulan', '1210000', '6050000'],
            ['5.1.02.01.01.0001', 'Belanja Bahan Promosi', '2', 'Paket', '5000000', '10000000']
        ];
    }
}
