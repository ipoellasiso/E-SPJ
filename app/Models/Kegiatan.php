<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $fillable = ['id_program', 'kode', 'nama'];

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program', 'id');
    }

    public function subKegiatan()
    {
        return $this->hasMany(SubKegiatan::class, 'id_kegiatan');
    }
}
