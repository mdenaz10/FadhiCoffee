<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\TransaksiProduk;
use App\Models\MovingAverage;
use Illuminate\Support\Facades\DB;

class ForecastingController extends Controller
{
  public function forecast()
  {
    $produks = Produk::with('bahanBaku')->get();
    $forecastData = [];

    foreach ($produks as $produk) {
      $data = $this->calculateMovingAverage($produk->id);
      if ($data) {
        $data['material_needs'] = $this->calculateMaterialNeeds($produk, $data['forecast']);
        $forecastData[$produk->id] = $data;
      }
    }

    return view('admin.forecast', compact('produks', 'forecastData'));
  }


  private function calculateMovingAverage($produkId)
  {
    $maPeriod = 7;
    $forecastDays = 7;

    // Ambil data penjualan historis
    $penjualan = TransaksiProduk::select(
      DB::raw('DATE(transaksi.tanggal_transaksi) as tanggal'),
      DB::raw('SUM(jumlah) as total_terjual')
    )
      ->join('transaksi', 'transaksi_produk.transaksi_id', '=', 'transaksi.id')
      ->where('transaksi_produk.produk_id', $produkId)
      ->groupBy('tanggal')
      ->orderBy('tanggal', 'ASC')
      ->get();

    if ($penjualan->isEmpty()) {
      return null;
    }

    // Format data penjualan
    $salesData = [];
    foreach ($penjualan as $item) {
      $salesData[$item->tanggal] = $item->total_terjual;
    }

    // Hitung moving average
    $dates = array_keys($salesData);
    $values = array_values($salesData);
    $movingAverages = [];

    for ($i = 0; $i < count($values); $i++) {
      $sum = 0;
      $count = 0;
      for ($j = $i; $j >= 0 && $j >= $i - ($maPeriod - 1); $j--) {
        $sum += $values[$j];
        $count++;
      }
      $movingAverages[$dates[$i]] = $count > 0 ? round($sum / $count, 2) : 0;
    }

    // Prediksi 7 hari ke depan
    $lastValues = array_slice($values, -$maPeriod);
    $forecast = [];
    $lastDate = end($dates);

    for ($i = 1; $i <= $forecastDays; $i++) {
      $nextDate = date('Y-m-d', strtotime($lastDate . " +{$i} days"));
      $avg = round(array_sum($lastValues) / count($lastValues), 2);
      $forecast[$nextDate] = $avg;
      array_shift($lastValues);
      $lastValues[] = $avg;
    }

    return [
      'historical' => $movingAverages,
      'forecast' => $forecast,
      'last_7_days' => array_slice($movingAverages, -7, 7, true)
    ];
  }

  private function calculateMaterialNeeds($produk, $forecast)
  {
    // $totalNeeded = 0;
    // foreach ($produk->bahanBaku as $bahan) {
    //   $totalNeeded += ceil($bahan->pivot->jumlah * array_sum($forecast));
    // }
    // return "{$totalNeeded} bahan";
    $result = [];

    foreach ($produk->bahanBaku as $bahan) {
        $kebutuhanTotal = ceil($bahan->pivot->jumlah * array_sum($forecast));
        $stokSaatIni = $bahan->stok;

        if ($kebutuhanTotal > $stokSaatIni) {
            $kekurangan = $kebutuhanTotal - $stokSaatIni;
            $result[] = "+{$kekurangan}{$bahan->satuan} {$bahan->nama}";
        }
    }

    return empty($result) ? 'Cukup' : implode(', ', $result);
  }
  public function storeDailyForecast()
  {
    $produks = Produk::with('bahanBaku')->get();

    foreach ($produks as $produk) {
      $data = $this->calculateMovingAverage($produk->id);

      if ($data) {
        foreach ($data['forecast'] as $tanggal => $jumlah) {
          // Menyimpan data forecast harian ke tabel moving_averages
          MovingAverage::updateOrCreate(
            ['produk_id' => $produk->id, 'tanggal' => $tanggal], // mencari data berdasarkan produk_id dan tanggal
            [
              'moving_average' => $jumlah, // Menyimpan nilai moving average
              'produk_id' => $produk->id, // Menyimpan produk_id
            ]
          );
        }
      }
    }
  }
}
