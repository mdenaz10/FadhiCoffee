<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransaksiProdukImport;

class TestImportCommand extends Command
{
  protected $signature = 'import:test {file}';
  protected $description = 'Test import transaksi dari file excel';

  public function handle()
  {
    $path = $this->argument('file');

    if (!Storage::exists($path)) {
      $this->error("File tidak ditemukan: $path");
      return 1;
    }

    $this->info("Mengimport file: " . $path);

    try {
      $import = new TransaksiProdukImport();
      Excel::import($import, Storage::path($path));

      $this->info("Import berhasil!");
      return 0;
    } catch (\Exception $e) {
      $this->error("Error: " . $e->getMessage());
      $this->error($e->getTraceAsString());
      return 1;
    }
  }
}
