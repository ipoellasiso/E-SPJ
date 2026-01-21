<?php

namespace App\Exports;

use App\Models\RincianObjek;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RincianObjekExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return RincianObjek::with('objek')->orderBy('kode', 'asc')->get();
    }

    public function headings(): array
    {
        return ['Kode', 'Uraian Rincian', 'Objek Belanja'];
    }

    public function map($r): array
    {
        return [$r->kode, $r->uraian, optional($r->objek)->uraian];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
