<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidangUrusan extends Model
{
    protected $table = 'bidang_urusan';
    protected $fillable = ['id_urusan', 'kode', 'nama'];

    public function urusan()
    {
        return $this->belongsTo(Urusan::class, 'id_urusan', 'id');
    }

    // public function unit()
    // {
    //     return $this->hasMany(UnitOrganisasi::class, 'id_bidang');
    // }

    public function program() {
        return $this->hasMany(Program::class, 'id_bidang');
    }
}
