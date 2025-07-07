<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
  public function index(Request $request)
  {
    $tanggal = $request->input('tanggal');
    $bulan = $request->input('bulan');
    $filter = $request->input('filter', 'tanggal'); // default filter by tanggal

    $transaksi = collect();
    $totalPendapatan = 0;

    if ($filter === 'tanggal' && $tanggal) {
      $transaksi = Transaksi::whereDate('tanggal_transaksi', $tanggal)
        ->with('transaksiProduk.produk')
        ->orderBy('tanggal_transaksi', 'desc')
        ->get();
    } elseif ($filter === 'bulan' && $bulan) {
      $transaksi = Transaksi::whereMonth('tanggal_transaksi', Carbon::parse($bulan)->month)
        ->whereYear('tanggal_transaksi', Carbon::parse($bulan)->year)
        ->with('transaksiProduk.produk')
        ->orderBy('tanggal_transaksi', 'desc')
        ->get();
    }

    $totalPendapatan = $transaksi->pluck('transaksiProduk')->flatten()->sum('total_harga');

    return view('laporan.index', compact('transaksi', 'totalPendapatan', 'tanggal', 'bulan', 'filter'));
  }
}
