<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BahanBaku;

class BahanBakuSeeder extends Seeder
{
    public function run()
    {
        BahanBaku::create([
            'nama' => 'Tepung',
            'satuan' => 'gram',
            'stok' => 1000
        ]);

        BahanBaku::create([
            'nama' => 'Minyak',
            'satuan' => 'liter',
            'stok' => 5
        ]);
    }
}
