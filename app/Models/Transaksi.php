<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $fillable = [
        'id',
        'tanggal_transaksi',
        'total_harga',
    ];

    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'transaksi_produk')
                    ->withPivot('jumlah', 'total_harga')
                    ->withTimestamps();
    }

    public function transaksiProduk()
{
    return $this->hasMany(TransaksiProduk::class, 'transaksi_id');
}

}
