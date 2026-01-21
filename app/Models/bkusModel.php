<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bkusModel extends Model
{
    use HasFactory;
    protected $table = "tb_transaksi";
    protected $primaryKey = "id_transaksi";
    protected $fillable = [
        'id_rekening',
        'id_opd',
        'id_bank',
        'uraian',
        'ket',
        'status1',
        'status2',
        'status3',
        'no_buku',
        'tgl_transaksi',
        'nilai_transaksi',
        'created_at',
        'updated_at',
        'tahun',
    ];
}
