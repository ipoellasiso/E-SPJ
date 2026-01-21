<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objek extends Model
{
    protected $table = 'objek';
    protected $fillable = ['id_jenis', 'kode', 'uraian'];

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function rincian_objek()
    {
        return $this->belongsTo(\App\Models\Jenis::class, 'id_jenis', 'id');
    }
}

