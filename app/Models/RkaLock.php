<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RkaLock extends Model
{
    protected $table = 'rka_lock';
    protected $fillable = ['tahap','is_locked'];
}
