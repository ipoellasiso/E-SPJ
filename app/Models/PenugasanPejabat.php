<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenugasanPejabat extends Model
{
    protected $table = 'penugasan_pejabat';
    protected $fillable = ['id_anggaran', 'id_pejabat', 'peran'];

    public function pejabat()
    {
        return $this->belongsTo(Pejabat::class, 'id_pejabat');
    }

    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class, 'id_anggaran');
    }
}
