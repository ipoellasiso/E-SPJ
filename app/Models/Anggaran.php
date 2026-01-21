<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    protected $table = 'anggaran';
    protected $fillable = [
        'id_subkegiatan',
        'tahun', 
        'sumber_dana', 
        'lokasi',
        'waktu_pelaksanaan', 
        'kelompok_sasaran', 
        'pagu_anggaran', 
        'keterangan',
        'id_unit',
        'realisasi',
        'sisa_pagu',
        'id_pptk'
    ];

    public function rincian()
    {
        return $this->hasMany(RincianAnggaran::class, 'id_anggaran');
    }

    public function indikator()
    {
        return $this->hasMany(IndikatorKinerja::class, 'id_anggaran');
    }

    public function pejabat()
    {
        return $this->hasMany(PenugasanPejabat::class, 'id_anggaran');
    }

    public function subKegiatan()
    {
        return $this->belongsTo(SubKegiatan::class, 'id_subkegiatan');
    }

    public function unit()
    {
        return $this->belongsTo(UnitOrganisasi::class, 'id_unit', 'id');
    }

    public function pptk()
    {
        return $this->belongsTo(Pptk::class, 'id_pptk');
    }
}
