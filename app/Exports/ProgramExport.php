<?php

namespace App\Exports;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProgramExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Program::with('bidang')->orderBy('kode', 'asc')->get();
    }

    public function headings(): array
    {
        return ['Kode', 'Nama Program', 'Nama Bidang Urusan'];
    }

    public function map($program): array
    {
        return [
            $program->kode,
            $program->nama,
            optional($program->bidang)->nama,
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
