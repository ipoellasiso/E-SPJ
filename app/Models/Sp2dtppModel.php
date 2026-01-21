<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sp2dtppModel extends Model
{
    use HasFactory;
    protected $table = "sp2dtpp";
    protected $primaryKey = "id";
    protected $fillable = [
        'id_belanja1',
        'periode',
        'status1',
        'status2',
        'id_sp2d'
    ];
}
