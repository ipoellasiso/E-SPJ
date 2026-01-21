<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Sp2dLogModel extends Model
{
    use HasFactory;
    protected $table = "sp2d_logs";
    protected $primaryKey = "id";
    protected $fillable = [
        'user_id',
        'user_name',
        'nomor_sp2d',
        'nama_skpd',
        'file_path',
        'uploaded_at'
    ];
}
