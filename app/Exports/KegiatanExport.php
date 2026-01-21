<?php

namespace App\Exports;

use App\Models\Kegiatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KegiatanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Kegiatan::with('program')->orderBy('kode', 'asc')->get();
    }

    public function headings(): array
    {
        return ['Kode', 'Nama Kegiatan', 'Nama Program'];
    }

    public function map($keg): array
    {
        return [
            $keg->kode,
            $keg->nama,
            optional($keg->program)->nama,
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
