<?php

namespace App\Exports;

use App\Models\SubRincianObjek;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubRincianObjekExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return SubRincianObjek::with('rincian')->orderBy('kode', 'asc')->get();
    }

    public function headings(): array
    {
        return ['Kode', 'Uraian Sub Rincian', 'Rincian Objek'];
    }

    public function map($sub): array
    {
        return [
            $sub->kode,
            $sub->uraian,
            optional($sub->rincian)->uraian,
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
