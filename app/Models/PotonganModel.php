<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PotonganModel extends Model
{
    use HasFactory;
    protected $table = 'potongan2';
    protected $fillable = [
        'id', 'id_potongan', 'id_rincianbpjs', 'id_rinciantaspen',
        'jenis_pajak', 'nilai_pajak', 'ebilling', 'status1',
        'id_pajakkpp', 'created_at', 'updated_at'
    ];

    public function sp2d()
    {
        return $this->belongsTo(Sp2dModel::class, 'id_potongan', 'idhalaman');
    }
}
