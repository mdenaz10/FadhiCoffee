<?php

namespace App\Models;

use App\Models\BahanBaku;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
  use HasFactory;

  protected $table = 'produk';
  protected $fillable = ['nama', 'harga',];

  public function komposisi()
  {
    return $this->belongsToMany(BahanBaku::class, 'produk_bahan_baku')->withPivot('jumlah')
      ->withTimestamps();
  }

  public function transaksi()
  {
    return $this->belongsToMany(Transaksi::class, 'transaksi_produk')
      ->withPivot('jumlah', 'total_harga')
      ->withTimestamps();
  }

  public function bahanBaku()
  {
    return $this->belongsToMany(BahanBaku::class, 'produk_bahan_baku')
      ->withPivot('jumlah')
      ->withTimestamps();
  }

  public function transaksiProduk()
  {
    return $this->hasMany(TransaksiProduk::class, 'produk_id');
  }
}
