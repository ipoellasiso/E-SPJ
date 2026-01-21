<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenCounter extends Model
{
    protected $table = 'dokumen_counter';
    protected $fillable = [
        'id_unit',
        'tahun',
        'jenis_dokumen',
        'nomor_terakhir',
    ];
}
