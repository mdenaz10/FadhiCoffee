<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransaksiProdukImport;

class TransaksiProdukController extends Controller
{
  public function import(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    $file = $request->file('file');

    try {
      // Simpan file sementara untuk inspeksi
      $path = $file->store('temp');
      \Log::info("File stored at: " . storage_path('app/' . $path));

      $import = new TransaksiProdukImport();
      Excel::import($import, $file);

      return redirect()->route('admin.tsindex')->with('success', 'Import transaksi berhasil!');
    } catch (\Exception $e) {
      \Log::error("Import error: " . $e->getMessage());
      \Log::error($e->getTraceAsString());

      return back()
        ->with('error', 'Error importing file: ' . $e->getMessage())
        ->withInput();
    }
  }
}
