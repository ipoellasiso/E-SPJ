<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sp2dModel extends Model
{
    use HasFactory;
    protected $table = 'sp2d';
    protected $primaryKey = 'idhalaman';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idhalaman', 'id_sp2d', 'jenis', 'tahun', 'nomor_rekening', 'nama_bank', 'nomor_sp2d',
        'tanggal_sp2d', 'nama_skpd', 'nama_sub_skpd', 'nama_pihak_ketiga', 'no_rek_pihak_ketiga',
        'nama_rek_pihak_ketiga', 'bank_pihak_ketiga', 'npwp_pihak_ketiga', 'keterangan_sp2d',
        'nilai_sp2d', 'nomor_spm', 'tanggal_spm', 'nama_ibu_kota', 'nama_bud_kbud',
        'jabatan_bud_kbud', 'nip_bud_kbud', 'status1', 'status2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->idhalaman)) {
                $model->idhalaman = strtoupper(Str::random(10)); // Generate kode acak
            }
        });
    }

    public function belanja()
    {
        return $this->hasMany(BelanjalsguModel::class, 'id_sp2d', 'idhalaman');
    }

    public function potongan()
    {
        return $this->hasMany(PotonganModel::class, 'id_potongan', 'idhalaman');
    }

}
