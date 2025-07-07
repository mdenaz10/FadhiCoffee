<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'produk_bahan_baku';
    protected $fillable = ['produk_id', 'bahan_baku_id', 'jumlah'];
   
}
