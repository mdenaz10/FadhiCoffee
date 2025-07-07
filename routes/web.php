<?php

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ForecastingController;
use App\Http\Controllers\TransaksiProdukController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
  return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  Route::get('/dashboard', function () {
    if (Auth::user() && Auth::user()->role == 'admin') { // Gunakan Auth::user()
      return redirect('/admin/dashboard');
    } elseif (Auth::user() && Auth::user()->role == 'owner') { // Gunakan Auth::user()
      return redirect('/owner/dashboard');
    }
    return redirect('/');
  })->name('dashboard'); // ✅ Tambahkan ini;
});

// Route::middleware(['auth', 'role:kasir'])->group(function () {
//   Route::get('/kasir/dashboard', [TransaksiController::class, 'kasirDashboard'])->name('kasir.dashboard');
//   Route::get('/admin/ts-create', [TransaksiController::class, 'create'])->name('admin.tscreate');
//   Route::post('/admin/ts-store', [TransaksiController::class, 'store'])->name('admin.tsstore');
//   Route::get('/admin/ts-index', [TransaksiController::class, 'index'])->name('admin.tsindex');
//   Route::delete('/admin/ts/{id}', [TransaksiController::class, 'destroy'])->name('admin.tsdestroy');
//   Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
//   Route::post('/import-transaksi', [TransaksiProdukController::class, 'import'])->name('transaksi.import');
//   Route::get('/format-excel/a', [App\Http\Controllers\FormatExcelController::class, 'showFixForm'])
//     ->name('show.fix.excel');
//   Route::post('/format-excel', [App\Http\Controllers\FormatExcelController::class, 'fixExcelFormat'])
//     ->name('fix.excel');
// });

Route::middleware(['auth', 'role:owner'])->group(function () {
  Route::get('/owner/dashboard', [TransaksiController::class, 'kasirDashboard'])->name('kasir.dashboard');


  Route::get('/owner/forecast', [ForecastingController::class, 'forecast'])->name('forecast');
  Route::get('/check-bahan-baku/{id}', [ForecastingController::class, 'checkBahanBaku']);
  Route::get('/produk/{id}/bahan-baku', [ForecastingController::class, 'getBahanBakuByProduk']);
  Route::get('/data-penjualan/{id}', [ForecastingController::class, 'getDataPenjualan']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
  Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
  Route::get('/admin/bbindex', [AdminController::class, 'bbindex'])->name('admin.bbindex');
  Route::get('/admin/bb-create', [AdminController::class, 'bbcreate'])->name('admin.bbcreate');
  Route::post('/admin/bb-store', [AdminController::class, 'bbstore'])->name('admin.bbstore');
  Route::delete('admin/bb/{id}', [AdminController::class, 'bbdestroy'])->name('admin.bbdestroy');
  Route::get('/admin/produk/{id}/edit', [AdminController::class, 'pdedit'])->name('admin.pdedit');
  Route::put('/admin/produk/{id}', [AdminController::class, 'pdupdate'])->name('admin.pdupdate');
  Route::get('/admin/bahanbaku/{id}/edit', [AdminController::class, 'bbedit'])->name('admin.bbedit');
  Route::put('/admin/bahanbaku/{id}', [AdminController::class, 'bbupdate'])->name('admin.bbupdate');

  Route::get('/admin/pd-index', [AdminController::class, 'pdindex'])->name('admin.pdindex');
  Route::get('/admin/pd-create', [AdminController::class, 'pdcreate'])->name('admin.pdcreate');
  Route::post('/admin/pd-store', [AdminController::class, 'pdstore'])->name('admin.pdstore');
  Route::delete('admin/pd/{id}', [AdminController::class, 'pddestroy'])->name('admin.pddestroy');

  Route::get('/admin/us-index', [AdminController::class, 'usindex'])->name('admin.usindex');
  Route::post('/admin/us/{id}/update-password', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');
  Route::delete('/us/{id}', [AdminController::class, 'usdestroy'])->name('admin.usdestroy');
  Route::post('/admin/users/store', [AdminController::class, 'usstore'])->name('admin.usstore');
  Route::get('/admin/users/create', [AdminController::class, 'uscreate'])->name('admin.uscreate');
  Route::post('/admin/users/store', [AdminController::class, 'usstore'])->name('admin.usstore');

  Route::get('/admin/forecast', [ForecastingController::class, 'forecast'])->name('admin.forecast');
  Route::get('/check-bahan-baku/{id}', [ForecastingController::class, 'checkBahanBaku']);
  Route::get('/produk/{id}/bahan-baku', [ForecastingController::class, 'getBahanBakuByProduk']);
  Route::get('/data-penjualan/{id}', [ForecastingController::class, 'getDataPenjualan']);

  // Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
  // Route::get('/laporan/per-produk', [LaporanController::class, 'perProduk'])->name('laporan.perProduk');
  // Route::get('/laporan/per-bulan', [LaporanController::class, 'perBulan'])->name('laporan.perBulan');

  Route::get('/admin/ts-create', [TransaksiController::class, 'create'])->name('admin.tscreate');
  Route::post('/admin/ts-store', [TransaksiController::class, 'store'])->name('admin.tsstore');
  Route::get('/admin/ts-index', [TransaksiController::class, 'index'])->name('admin.tsindex');
  Route::delete('/admin/ts/{id}', [TransaksiController::class, 'destroy'])->name('admin.tsdestroy');
  Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
  Route::post('/import-transaksi', [TransaksiProdukController::class, 'import'])->name('transaksi.import');
  Route::get('/format-excel/a', [App\Http\Controllers\FormatExcelController::class, 'showFixForm'])
    ->name('show.fix.excel');
  Route::post('/format-excel', [App\Http\Controllers\FormatExcelController::class, 'fixExcelFormat'])
    ->name('fix.excel');
});

Route::get('/owner/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/per-produk', [LaporanController::class, 'perProduk'])->name('laporan.perProduk');
Route::get('/laporan/per-bulan', [LaporanController::class, 'perBulan'])->name('laporan.perBulan');


require __DIR__ . '/auth.php';
