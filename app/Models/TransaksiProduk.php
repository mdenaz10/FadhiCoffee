<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiProduk extends Model
{
    use HasFactory;

    protected $table = 'transaksi_produk';
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah',
        'total_harga',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}

