<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';
    protected $fillable = ['id_bidang', 'kode', 'nama'];

    public function bidang() {
        return $this->belongsTo(BidangUrusan::class, 'id_bidang', 'id');
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'id_program', 'id');
    }
}
