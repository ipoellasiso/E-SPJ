<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubRincianObjek extends Model
{
    protected $table = 'sub_rincian_objek';
    protected $fillable = ['id_rincian_objek', 'kode', 'uraian'];

    public function rincian_objek()
    {
        return $this->belongsTo(\App\Models\RincianObjek::class, 'id_rincian_objek', 'id');
    }

     public function rincianAnggaran()
    {
        return $this->hasMany(RincianAnggaran::class, 'id_rincian_objek', 'id');
    }
}

