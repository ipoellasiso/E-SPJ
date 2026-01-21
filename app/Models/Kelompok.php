<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    protected $table = 'kelompok';
    protected $fillable = ['id_akun', 'kode', 'uraian'];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id');
    }

    public function jenis()
    {
        return $this->hasMany(Jenis::class);
    }
}

