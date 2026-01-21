<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pptk extends Model
{
   protected $table = 'pptk';
    protected $fillable = ['id_unit', 'nama', 'nip', 'jabatan'];

    public function unit()
    {
        return $this->belongsTo(UnitOrganisasi::class, 'id_unit');
    }

    public function anggaran()
    {
        return $this->hasMany(Anggaran::class, 'id_pptk');
    }
}
