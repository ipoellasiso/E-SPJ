<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKegiatan extends Model
{
    protected $table = 'sub_kegiatan';
    protected $fillable = ['id_kegiatan', 'kode', 'nama', 'id_pptk'];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan', 'id');
    }

    public function anggaran()
    {
        return $this->hasMany(Anggaran::class, 'id_subkegiatan');
    }

    public function pptk()
    {
        return $this->belongsTo(Pptk::class, 'id_pptk');
    }
}
