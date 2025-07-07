<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ForecastingController;

class StoreForecast extends Command
{
    protected $signature = 'forecast:store-daily';
    protected $description = 'Simpan data forecast harian ke database';

    public function handle()
    {
        $controller = new ForecastingController();
        $controller->storeDailyForecast();

        $this->info('Forecast harian berhasil disimpan 🌤️');
    }
}
