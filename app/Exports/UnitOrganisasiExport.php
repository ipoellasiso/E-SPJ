<?php

namespace App\Exports;

use App\Models\UnitOrganisasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UnitOrganisasiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return UnitOrganisasi::with('bidang')->orderBy('kode', 'asc')->get();
    }

    public function headings(): array
    {
        return ['Kode', 'Nama Unit', 'Nama Bidang Urusan'];
    }

    public function map($unit): array
    {
        return [
            $unit->kode,
            $unit->nama,
            optional($unit->bidang)->nama,
        ];
    }
}
