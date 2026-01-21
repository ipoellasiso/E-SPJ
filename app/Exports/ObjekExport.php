<?php

namespace App\Exports;

use App\Models\Objek;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ObjekExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Objek::with('jenis')->orderBy('kode', 'asc')->get();
    }

    public function headings(): array
    {
        return ['Kode', 'Uraian Objek', 'Jenis Belanja'];
    }

    public function map($objek): array
    {
        return [
            $objek->kode,
            $objek->uraian,
            optional($objek->jenis)->uraian,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
