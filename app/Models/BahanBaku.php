<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahan_baku';
    protected $fillable = ['nama','stok','satuan'];

    // public function pembelian()
    // {
    //     return $this->hasMany(BahanBakuMasuk::class);
    // }
    
    // public function tambahStok($jumlah)
    // {
    //     $this->stok += $jumlah;
    //     $this->save();
    // }

    public function produk(){
        return $this->belongsToMany(Produk::class, 'produk_bahan_baku')->withPivot('jumlah')->withTimestamps();
    }

    public function kurangiStok($jumlah)
    {
        $this->stok -= $jumlah;
        $this->save();
    }
}
