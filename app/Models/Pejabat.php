<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    protected $table = 'pejabat';
    protected $fillable = ['nama', 'nip', 'jabatan'];

    public function penugasan()
    {
        return $this->hasMany(PenugasanPejabat::class, 'id_pejabat');
    }
}
