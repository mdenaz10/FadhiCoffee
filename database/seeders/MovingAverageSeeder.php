<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MovingAverageSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama
        DB::table('moving_averages')->truncate();

        // Data dummy untuk 3 hari terakhir
        $data = [
            [
                'tanggal' => '2025-02-04',
                'moving_average' => 4.5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tanggal' => '2025-02-05',
                'moving_average' => 5.2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tanggal' => '2025-02-06',
                'moving_average' => 5.33,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Masukkan ke database
        DB::table('moving_averages')->insert($data);
    }
}
