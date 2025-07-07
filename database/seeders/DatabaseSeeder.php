<?php
namespace Database\Seeders;
use App\Models\Produk;
use App\Models\BahanBaku;
use Illuminate\Database\Seeder;

// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
      //buatproduk
      $produk = Produk::create([
        'nama' => 'Ayam Geprek',
        'harga' => 20000
      ]);

       // Buat Bahan Baku
       $ayam = BahanBaku::create(['nama' => 'Ayam', 'stok' => 4, 'satuan' => 'kg']);
       $tepung = BahanBaku::create(['nama' => 'Tepung', 'stok' => 2,'satuan' => 'gram']);
       $minyak = BahanBaku::create(['nama' => 'Minyak', 'stok' => 1, 'satuan' => 'liter']);

       $produk->bahanBaku()->attach([
        $ayam->id => ['jumlah' => 0.3],  // 300 gram ayam
        $tepung->id => ['jumlah' => 100], // 100 gram tepung
        $minyak->id => ['jumlah' => 0.1], // 100 ml minyak
      ]);

// User::factory(10)->create();
// User::factory()->create([
//     'name' => 'Test User',
//     'email' => 'test@example.com',
// ]);
    }
}
