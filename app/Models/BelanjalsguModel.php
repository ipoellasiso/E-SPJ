<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BelanjalsguModel extends Model
{
    use HasFactory;
    protected $table = 'belanja1';
    protected $fillable = [
        'id', 'norekening', 'uraian', 'nilai', 'id_sp2d',
        'status1', 'status2', 'created_at', 'updated_at',
        'kegiatan', 'sub_kegiatan'
    ];

    public function sp2d()
    {
        return $this->belongsTo(Sp2dModel::class, 'id_sp2d', 'idhalaman');
    }
}
