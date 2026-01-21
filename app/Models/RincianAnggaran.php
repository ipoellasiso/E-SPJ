<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RincianAnggaran extends Model
{
    protected $table = 'rincian_anggaran';
    protected $fillable = [
        'id_anggaran', 'kode_rekening', 'uraian',
        'koefisien', 'satuan', 'harga', 'ppn',
        'jumlah', 'keterangan', 'id_parent', 'urutan'
    ];

    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class, 'id_anggaran');
    }

    public function subRincianObjek()
    {
        return $this->belongsTo(SubRincianObjek::class, 'id_rincian_objek', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(RincianAnggaran::class, 'id_parent');
    }

    public function children()
    {
        return $this->hasMany(RincianAnggaran::class, 'id_parent');
    }
}
