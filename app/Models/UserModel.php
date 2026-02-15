<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class UserModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'id_opd',
        'fullname',
        'email',
        'password',
        'role',
        'gambar',
        'is_active',
        'tahun',
        'id_unit',
        
        // Pejabat
        'kepala', 'nip_kepala',
        'bendahara', 'nip_bendahara',
        'ppk', 'nip_ppk',
        'pejabatbarang', 'nip_pejabatbarang',
        'bend_barang', 'nip_bend_barang',

        // SK & Alamat
        'nomor_sk', 'tanggal_sk', 'alamat',

    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function unit()
    {
        return $this->belongsTo(UnitOrganisasi::class, 'id_unit', 'id');
    }
}
