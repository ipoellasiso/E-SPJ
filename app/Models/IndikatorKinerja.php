<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorKinerja extends Model
{
    protected $table = 'indikator_kinerja';
    protected $fillable = [
        'id_anggaran', 'jenis', 'tolok_ukur', 'target_kinerja', 'satuan'
    ];

    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class, 'id_anggaran');
    }
}
