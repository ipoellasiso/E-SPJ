<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianObjek extends Model
{
    protected $table = 'rincian_objek';
    protected $fillable = ['id_objek', 'kode', 'uraian'];

    public function objek()
    {
        return $this->belongsTo(\App\Models\Objek::class, 'id_objek', 'id');
    }

    public function sub_rincian_objek()
    {
        return $this->hasMany(SubRincianObjek::class);
    }
}
