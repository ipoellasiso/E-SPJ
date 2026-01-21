<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekanan extends Model
{
    use HasFactory;
    protected $table = 'rekanan'; // ← sesuai tabel kamu
    protected $fillable = [
        'id',
        'nama_rekanan',
        'alamat',
        'npwp',
        'jabatan',
        'nip'
    ];
}
