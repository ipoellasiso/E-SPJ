<?php

namespace App\Exports;

use App\Models\SubKegiatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubKegiatanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return SubKegiatan::with('kegiatan')->orderBy('kode', 'asc')->get();
    }

    public function headings(): array
    {
        return ['Kode', 'Nama Sub Kegiatan', 'Nama Kegiatan'];
    }

    public function map($sub): array
    {
        return [
            $sub->kode,
            $sub->nama,
            optional($sub->kegiatan)->nama,
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
