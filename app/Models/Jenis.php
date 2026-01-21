<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table = 'jenis';
    protected $fillable = ['id_kelompok', 'kode', 'uraian'];

    public function kelompok()
    {
        return $this->belongsTo(\App\Models\Kelompok::class, 'id_kelompok', 'id');
    }

    public function objek()
    {
        return $this->hasMany(Objek::class);
    }
}

