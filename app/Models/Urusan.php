<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Urusan extends Model
{
    protected $table = 'urusan';
    protected $fillable = ['kode', 'nama'];

    public function bidang()
    {
        return $this->hasMany(BidangUrusan::class, 'id_urusan');
    }
}
