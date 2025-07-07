<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovingAverage extends Model {
    use HasFactory;

    protected $fillable = ['tanggal', 'moving_average', 'produk_id'];
}

