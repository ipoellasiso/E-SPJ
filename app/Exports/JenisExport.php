<?php

namespace App\Exports;

use App\Models\Jenis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JenisExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Jenis::with('kelompok')->orderBy('kode', 'asc')->get();
    }

    public function headings(): array
    {
        return ['Kode', 'Uraian Jenis', 'Kelompok Belanja'];
    }

    public function map($jenis): array
    {
        return [
            $jenis->kode,
            $jenis->uraian,
            optional($jenis->kelompok)->uraian,
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
